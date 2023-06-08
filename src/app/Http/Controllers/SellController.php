<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Condition;
use App\Models\ItemCategory;
use App\Models\ItemCondition;
use App\Models\Item;

class SellController extends Controller
{
    public function showSellForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell.sell', compact('categories', 'conditions'));
    }

    public function sell(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'item_name' => 'required|max:50',
            'price' => 'required|integer|max:9999999',
            'image' => 'required|file|image',
            'about' => 'required|max:255',
            'category' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    $nonEmptyCategories = array_filter($value, function ($category) {
                        return !empty($category);
                    });
                    if (count($nonEmptyCategories) === 0) {
                        $fail('カテゴリーを1つ以上選択してください');
                    }
                    $uniqueCategories = array_unique($nonEmptyCategories);
                    if (count($uniqueCategories) < count($nonEmptyCategories)) {
                        $fail('同じカテゴリーは選択できません');
                    }
                },
            ],
            'condition' => 'required',
        ], [
            'item_name.max' => '商品名は50文字以内で入力してください',
            'about.max' => '商品の説明は255文字以内で入力してください',
            'image.required' => '画像が選択されていません',
            'category.required' => 'カテゴリーは1つ以上選択する必要があります',
            'price.integer' => '販売価格は半角数字で入力してください',
            'price.max' => '9999999円以上の商品の出品はできません。'
        ]);

        $item = new Item;
        $item->user_id = Auth::id();
        $item->item_name = $request->item_name;
        $item->price = $request->price;
        $item->about = $request->about;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/items');
            $item->image = Storage::url($path);
        }

        $item->save();

        $categoryIds = Category::whereIn('category', $request->category)->pluck('id')->all();

        foreach ($categoryIds as $categoryId) {
            ItemCategory::create([
                'item_id' => $item->id,
                'category_id' => $categoryId,
            ]);
        }

        $conditionId = Condition::where('condition', $request->condition)->first()->id;

        ItemCondition::create([
            'item_id' => $item->id,
            'condition_id' => $conditionId,
        ]);

        return redirect()->route('sell-done');
    }

    public function sellDone()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('sell.sell_done');
    }
}

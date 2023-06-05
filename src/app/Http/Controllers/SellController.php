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
            'item_name' => 'required|max:255',
            'price' => 'required|integer',
            'image' => 'required|file|image',
            'about' => 'required',
            'category' => 'required|array|min:1|max:3',
            'category.*' => 'required|string|distinct',
            'condition' => 'required|string',
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

        return redirect()->back()->with('success', '商品を出品しました');
    }
}

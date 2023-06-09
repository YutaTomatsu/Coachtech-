<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\UserStaff;

class ShopEditController extends Controller
{
    public function showShopEditForm($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $shop = Shop::where('id', $id)->first();

        if (!$shop->shop_icon) {
            $shop->shop_icon = 'shops_icon/icon_default.svg';
        }

        if ($shop->shop_icon === 'shops_icon/icon_default.svg') {
            $shop->shop_icon = Storage::disk('s3')->url($shop->shop_icon);
        }

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.shop_edit', compact('user', 'shop', 'userStaff'));
    }

    public function shopEdit(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'shop_name' => 'required|max:50',
            'shop_icon' => 'file|image',
            'about' => 'required|max:255',
        ], [
            'shop_name.max' => 'ショップ名は50文字以内で入力してください',
            'about.max' => '商品の説明は255文字以内で入力してください',
        ]);

        $shop = Shop::where('id', $id)->first();
        $shop->shop_name = $request->shop_name;
        $shop->about = $request->about;

        if ($request->hasFile('shop_icon')) {
            $icon = $request->file('shop_icon');
            $path = Storage::disk('s3')->putFile('shops_icon', $icon);
            $shop->shop_icon = Storage::disk('s3')->url($path);
        }

        $shop->save();

        $id = $shop->user_id;

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return redirect()->route('show-shop', compact('id', 'userStaff'));
    }

    public function showShop($id)
    {
        $shop = Shop::where('user_id', $id)->first();

        return view('shop.shop_dashboard', compact('shop'));
    }
}

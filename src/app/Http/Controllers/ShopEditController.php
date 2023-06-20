<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
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

        if (!$user->icon) {
            $user->icon = 'icon/icon_user_2.svg';
        }

        if ($user->icon === 'icon/icon_user_2.svg') {
            $user->icon = Storage::url($user->icon);
        }

        $shop = Shop::where('id', $id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.shop_edit', compact('user','shop','userStaff'));
    }

    public function shopEdit(Request $request,$id)
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

        $shop = Shop::where('id',$id)->first();
        $shop->shop_name = $request->shop_name;
        $shop->about = $request->about;

        if ($request->hasFile('shop_icon')) {
            $icon = $request->file('shop_icon');
            $path = $icon->store('public/shops_icon');
            $shop->shop_icon = Storage::url($path);
        }

        $shop->save();

        $id = $shop->user_id;

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return redirect()->route('show-shop', compact('id','userStaff'));
    }

    public function showShop($id)
    {
        $shop = Shop::where('user_id', $id)->first();

        return view('shop.shop_dashboard', compact('shop'));
    }
}

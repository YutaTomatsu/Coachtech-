<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Shop;

class ShopController extends Controller
{
    public function showShopForm()
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

        $profile = Profile::where('user_id', $user->id)->first();
        return view('shop.create_shop', compact('profile', 'user'));
    }

    public function createShop(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'shop_name' => 'required|max:50|unique:shops,shop_name',
            'shop_icon' => 'file|image',
            'about' => 'required|max:255',
        ], [
            'shop_name.unique' => 'このショップ名は既に使われています',
            'shop_name.max' => 'ショップ名は50文字以内で入力してください',
            'about.max' => '商品の説明は255文字以内で入力してください',
        ]);

        $shop = new Shop;
        $shop->user_id = Auth::id();
        $shop->shop_name = $request->shop_name;
        $shop->about = $request->about;

        if ($request->hasFile('shop_icon')) {
            $icon = $request->file('shop_icon');
            $path = $icon->store('public/shops_icon');
            $shop->shop_icon = Storage::url($path);
        }

        $id = $shop->user_id;

        $shop->save();

        return redirect()->route('show-shop',compact('id'));
    }

    public function showShop($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $shop =Shop::where('user_id',$id)->first();

        return view('shop.shop_dashboard',compact('shop'));
    }
}
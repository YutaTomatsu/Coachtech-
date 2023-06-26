<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\ShopItem;
use App\Models\Coupon;

class AddressController extends Controller
{
    public function showChangeAddressForm($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $item = Item::where('items.id', $id)->first();

        return view('purchase.change_address', compact('item'));
    }

    public function changeAddress(Request $request,$id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validatedData = $request->validate([
            'postcode' => 'required|string|size:8|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'build' => 'nullable|string|max:255',
        ], [
            'postcode.string' => '郵便番号は文字列で入力してください。',
            'postcode.size' => '郵便番号は8文字で入力してください。',
            'postcode.regex' => '郵便番号は半角数字にハイフンを含めた形式で入力してください。',
            'address.string' => '住所は文字列で入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'build.string' => '建物名は文字列で入力してください。',
            'build.max' => '建物名は255文字以内で入力してください。',
        ]);

        $user = Auth::user();

        $item = Item::where('items.id', $id)->first();


        $addresses = Purchase::where('user_id', Auth::id())->where('item_id', $id)->first();
        if (!$addresses) {
            $addresses = new Purchase();
            $addresses->user_id = Auth::id();
        }

        $addresses->item_id = $id;
        $addresses->postcode = $request->input('postcode');
        $addresses->address = $request->input('address');
        $addresses->build = $request->input('build');

        $shopItemId = ShopItem::where('item_id', $id)->first();

        $coupons = null;

        if ($shopItemId) {
            $coupons = Coupon::where('shop_id', $shopItemId->shop_id)->get();
        }

        return view('purchase.purchase',compact('user','item','addresses', 'coupons'))->with('status','発送先が変更されました');
    }
}
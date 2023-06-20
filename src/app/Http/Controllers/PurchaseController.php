<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ShopItem;
use App\Models\Coupon;
use App\Models\Profile;

class PurchaseController extends Controller
{
    public function showPurchageForm($id)
    {
        if(!Auth::user()){
            return redirect()->route('login');
        }

        $user = Auth::user();

        $item = Item::where('items.id', $id)->first();

        $addresses = Profile::where('user_id',Auth::id())->first();

        $shopItemId = ShopItem::where('item_id',$id)->first();

        $coupons = null;

        if($shopItemId){
        $coupons = Coupon::where('shop_id',$shopItemId->shop_id)->get();
        }

        return view('purchase.purchase', compact('user','item','addresses','coupons'));
    }
}

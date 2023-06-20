<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\Shop;
use App\Models\UserStaff;

class CouponController extends Controller
{
    public function showCoupons($id)
    {
        $shop = Shop::where('id', $id)->first();
        $coupons = Coupon::where('shop_id', $id)->get();
        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.shop_coupons', compact('shop', 'coupons','userStaff'));
    }

    public function showCouponForm($id)
    {
        $shop = Shop::where('id', $id)->first();
        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.create_coupon', compact('shop','userStaff'));
    }

    public function createCoupon(Request $request, $id)
    {
        $validated = $request->validate([
            'coupon_name' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|integer|min:1',
        ]);

        $coupon = new Coupon();
        $coupon->shop_id = $id;
        $coupon->coupon_name = $validated['coupon_name'];
        $coupon->discount_type = $validated['discount_type'];
        $coupon->discount_value = $validated['discount_type'] === 'percentage' ? min(max($validated['discount_value'], 5), 90) : max($validated['discount_value'], 100);
        $coupon->save();

        return redirect()->back()->with('success', 'クーポンが作成されました！');
    }

    public function couponDestroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'クーポンを削除しました');
    }

}

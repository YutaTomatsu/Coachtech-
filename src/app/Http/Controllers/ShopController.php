<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Shop;
use App\Models\UserStaff;
use App\Models\Item;
use App\Models\ShopItem;
use App\Models\User;
use App\Models\ShopFollow;
use App\Models\Purchase;
use App\Models\Review;

class ShopController extends Controller
{
    public function showShopForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->icon) {
            $user->icon = 'shops_icon/icon_default.svg';
        }

        if ($user->icon === 'shops_icon/icon_default.svg') {
            $user->icon = Storage::disk('s3')->url($user->icon);
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
            'about' => 'max:255',
        ], [
            'shop_name.unique' => 'このショップ名は既に使われています',
            'shop_name.max' => 'ショップ名は50文字以内で入力してください',
            'shop_icon.image' => '画像の形式が正しくありません',
            'about.max' => '商品の説明は255文字以内で入力してください',
        ]);

        $shop = new Shop;
        $shop->user_id = Auth::id();
        $shop->shop_name = $request->shop_name;
        $shop->about = $request->about;

        if ($request->hasFile('shop_icon')) {
            $icon = $request->file('shop_icon');
            $path = Storage::disk('s3')->putFile('shops_icon', $icon);
            $shop->shop_icon = Storage::disk('s3')->url($path);
        }

        $id = $shop->user_id;

        $shop->save();

        return redirect()->route('show-shop', compact('id'));
    }

    public function showShop($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::where('user_id', $id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        $shopItems = ShopItem::where('shop_id',  $shop->id)->get();

        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        $shopItemIds = $shopItems->pluck('item_id')->toArray();

        $purchasedItemsIds = Purchase::whereIn('item_id', $shopItemIds)->pluck('item_id')->toArray();

        $sellingItemIds = array_diff($shopItemIds, $purchasedItemsIds);

        $purchasedItems = Item::wherein('id', $purchasedItemsIds)->get();

        $sellingItems = Item::wherein('id', $sellingItemIds)->get();

        return view('shop.shop_dashboard', compact('shop', 'userStaff', 'shopItems', 'purchasedItemIds', 'purchasedItems', 'sellingItems'));
    }

    public function showShopToppage($id)
    {

        $item = Item::where('id', $id)->first();

        $shop = Shop::where('id', $id)->first();

        $shopItems = ShopItem::where('shop_id', $id)->get();

        $user = User::where('users.id', $item->user_id)->first();

        $items = Item::where('items.user_id', $user->id)->get();

        $isFollowing = ShopFollow::where('user_id', Auth::id())
            ->where('shop_id', $shop->id)->first();

        $follower = ShopFollow::where('shop_id', $id)->count();

        if (!$user->icon) {
            $user->icon = 'icon/icon_user_2.svg';
        }

        if ($user->icon === 'icon/icon_user_2.svg') {
            $user->icon = Storage::url($user->icon);
        }

        $purchases = Purchase::where('user_id', $user->id)->get();

        $purchaseItems = collect();

        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        foreach ($purchases as $purchase) {
            $purchaseItem = Item::find($purchase->item_id);

            if ($purchaseItem) {
                $purchaseItems->push($purchaseItem);
            }
        }

        $totalReviews = Review::where('seller_id',  $user->id)->count();
        $reviewsAvg = Review::where('seller_id',  $user->id)->avg('rating');


        return view('shop.shop_toppage', compact('user', 'items', 'purchaseItems', 'reviewsAvg', 'totalReviews', 'isFollowing', 'follower', 'shop', 'shopItems', 'purchasedItemIds'));
    }
}

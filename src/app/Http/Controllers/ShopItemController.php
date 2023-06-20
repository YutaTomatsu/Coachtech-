<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\Review;
use App\Models\ShopReview;
use App\Models\ShopItem;
use App\Models\Shop;

class ShopItemController extends Controller
{
    public function showShopItem($id)
    {
        $item = Item::select('items.id', 'items.user_id', 'items.item_name', 'items.price', 'items.image', 'items.about', 'conditions.condition')
            ->leftJoin('items_categories', 'items.id', '=', 'items_categories.item_id')
            ->leftJoin('categories', 'items_categories.category_id', '=', 'categories.id')
            ->leftJoin('items_conditions', 'items.id', '=', 'items_conditions.item_id')
            ->leftJoin('conditions', 'items_conditions.condition_id', '=', 'conditions.id')
            ->where('items.id', $id)
            ->first();

        $categories = Category::whereIn('id', function ($query) use ($id) {
            $query->select('category_id')
                ->from('items_categories')
                ->where('item_id', $id);
        })->get();

        $mylist_items = array();
        if (Auth::check()) {
            $mylist_items = Auth::user()->mylists()->pluck('item_id')->toArray();
        }

        $comments = Comment::where('item_id', $id)->get();

        $purchasedItemId = Purchase::pluck('item_id')->toArray();

        $purchased = Purchase::where('item_id', $id)->where('user_id', Auth::id())->exists();

        $seller = User::where('id', $item->user_id)->first();

        if (!$seller->icon) {
            $seller->icon = 'icon/icon_user_2.svg';
        }

        if ($seller->icon === 'icon/icon_user_2.svg') {
            $seller->icon = Storage::url($seller->icon);
        }

        $totalReviews = Review::where('seller_id',  $seller->id)->count();
        $reviewsAvg = Review::where('seller_id',  $seller->id)->avg('rating');

        $reviewed = Review::where('user_id', Auth::id())->where('item_id', $item->id)->exists();

        $shopReviewed = ShopReview::where('user_id', Auth::id())->where('item_id', $item->id)->exists();


        $shopId = ShopItem::where('item_id', $id)->first();

        $shop = Shop::where('id', $shopId->shop_id)->first();

        $purchasedItem = Purchase::where('item_id',$id)->exists();

        return view('shop.shop_item_detail', compact('item', 'categories', 'mylist_items', 'comments', 'purchasedItemId', 'purchased', 'seller', 'totalReviews', 'reviewsAvg', 'reviewed', 'shop', 'shopReviewed', 'purchasedItem'));
    }

    public function shopItemDestroy(Item $item)
    {

        $id = Auth::id();

        DB::table('comments')->where('item_id', $item->id)->delete();
        DB::table('items_categories')->where('item_id', $item->id)->delete();
        DB::table('items_conditions')->where('item_id', $item->id)->delete();
        DB::table('mylists')->where('item_id', $item->id)->delete();
        DB::table('reviews')->where('item_id', $item->id)->delete();
        DB::table('shops_items')->where('item_id', $item->id)->delete();
        DB::table('shops_reviews')->where('item_id', $item->id)->delete();

        $item->delete();

        return redirect()->route('show-shop',compact('id'));
    }
}

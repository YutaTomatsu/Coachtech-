<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Review;
use App\Models\Follow;

class SellerController extends Controller
{

    public function showSeller($id)
    {

        $item = Item::where('id', $id)->first();

        $user = User::where('users.id', $item->user_id)->first();

        if (Auth::id() === $user->id) {
            return redirect()->route('mypage');
        }

        $items = Item::where('items.user_id', $user->id)->get();

        $isFollowing = Follow::where('user_id', Auth::id())
            ->where('seller_id', $item->user_id)->first();

        $following = Follow::where('user_id', $user->id)->count();
        $follower = Follow::where('seller_id', $user->id)->count();

        if (!$user->icon) {
            $user->icon = 'user_icon/icon_user_5.png';
        }

        if ($user->icon === 'user_icon/icon_user_5.png') {
            $user->icon = Storage::disk('s3')->url($user->icon);
        }

        $purchases = Purchase::where('user_id', $user->id)->get();

        $purchaseItems = collect();

        foreach ($purchases as $purchase) {
            $purchaseItem = Item::find($purchase->item_id);

            if ($purchaseItem) {
                $purchaseItems->push($purchaseItem);
            }
        }

        $totalReviews = Review::where('seller_id',  $user->id)->count();
        $reviewsAvg = Review::where('seller_id',  $user->id)->avg('rating');

        return view('seller.seller', compact('user', 'items', 'purchaseItems', 'reviewsAvg', 'totalReviews', 'isFollowing', 'following', 'follower'));
    }

    public function showFollowingSeller($id)
    {

        $user = User::where('users.id', $id)->first();

        if (Auth::id() === $user->id) {
            return redirect()->route('mypage');
        }

        $items = Item::where('items.user_id', $user->id)->get();

        $isFollowing = Follow::where('user_id', Auth::id())
            ->where('seller_id', $id)->first();

        $following = Follow::where('user_id', $user->id)->count();
        $follower = Follow::where('seller_id', $user->id)->count();

        if (!$user->icon) {
            $user->icon = 'icon/icon_user_2.svg';
        }

        if ($user->icon === 'icon/icon_user_2.svg') {
            $user->icon = Storage::url($user->icon);
        }

        $purchases = Purchase::where('user_id', $user->id)->get();

        $purchaseItems = collect();

        foreach ($purchases as $purchase) {
            $purchaseItem = Item::find($purchase->item_id);

            if ($purchaseItem) {
                $purchaseItems->push($purchaseItem);
            }
        }

        $totalReviews = Review::where('seller_id',  $user->id)->count();
        $reviewsAvg = Review::where('seller_id',  $user->id)->avg('rating');

        return view('seller.seller', compact('user', 'items', 'purchaseItems', 'reviewsAvg', 'totalReviews', 'isFollowing', 'following', 'follower'));
    }
}

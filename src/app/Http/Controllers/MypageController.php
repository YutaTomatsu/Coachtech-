<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Follow;
use App\Models\Review;
use App\Models\Shop;

class MypageController extends Controller
{
    public function showMypage()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->icon) {
            $user->icon = 'user_icon/icon_user_5.png';
        }

        if ($user->icon === 'user_icon/icon_user_5.png') {
            $user->icon = Storage::disk('s3')->url($user->icon);
        }

        $items = Item::where('items.user_id', Auth::id())
            ->get();

        $purchases = Purchase::where('user_id', $user->id)->get();

        $purchaseItems = collect();

        foreach ($purchases as $purchase) {
            $purchaseItem = Item::find($purchase->item_id);

            if ($purchaseItem) {
                $purchaseItems->push($purchaseItem);
            }
        }

        $following = Follow::where('user_id', $user->id)->count();
        $follower = Follow::where('seller_id', $user->id)->count();

        $totalReviews = Review::where('seller_id',  $user->id)->count();
        $reviewsAvg = Review::where('seller_id',  $user->id)->avg('rating');

        $haveShop = Shop::where('user_id',Auth::id())->exists();

        $notReviewItems = Purchase::where('purchases.user_id', Auth::id())
        ->leftJoin('reviews', function ($join) {
            $join->on('purchases.item_id', '=', 'reviews.item_id')
            ->on('purchases.user_id', '=', 'reviews.user_id');
        })
            ->whereNull('reviews.item_id')
            ->whereNull('reviews.user_id')
            ->select('purchases.item_id', 'purchases.user_id')
            ->get();

        $notReviews = collect();

        foreach ($notReviewItems as $notReviewItem) {
            $item = Item::find($notReviewItem->item_id);
            if ($item) {
                $notReviews->push($item);
            }
        }

        return view('mypage.mypage', compact('user', 'items','purchaseItems', 'following', 'follower','totalReviews','reviewsAvg','haveShop', 'notReviews'));
    }
}

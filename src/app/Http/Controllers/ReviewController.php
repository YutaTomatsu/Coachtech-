<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function showReviewForm($id)
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

        $seller = User::where('id', $item->user_id)->first();

        if (!$seller->icon) {
            $seller->icon = 'icon/icon_user_2.svg';
        }

        if ($seller->icon === 'icon/icon_user_2.svg') {
            $seller->icon = Storage::url($seller->icon);
        }

        $purchased = Purchase::where('user_id', Auth::id())
        ->where('item_id', $id)
        ->exists();

        $error_message = "購入後にレビューができます";

        if (!$purchased) {
            return redirect()->back()->with('error', '購入後にレビューができます');
        }

        
        return view('review.review_form', compact('item', 'categories', 'mylist_items', 'comments', 'purchasedItemId', 'seller'));
    }




    public function review(Request $request, $id)
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $validatedData = $request->validate(
            [
                'rating' => 'required',
                'comment' => 'required|string|max:255',
            ],
            [
                'rating.required' => '評価は必須項目です。',
                'comment.required' => 'コメントは必須項目です。',
                'comment.string' => 'コメントは文字列で入力してください。',
                'comment.max' => 'コメントは255文字以内で入力してください。',
            ]
        );

        $item = Item::where('id', $id)->first();
        $seller = User::where('id', $item->user_id)->first();
        $review = new Review();
        $review->user_id = Auth::id();
        $review->item_id = $id;
        $review->seller_id = $seller->id;
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->save();

        return view('review.review_done')->with('success', 'レビューを投稿しました');
    }

    public function showReviews($id)
    {
        $reviews = Review::with('user')->where('seller_id',$id)->get();

        $item = Item::where('id', $id)->first();

        $user = User::where('users.id', $item->user_id)->first();

        $items = Item::where('items.user_id', $user->id)->get();

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

        foreach ($reviews as $review) {

            if (!$review->user->icon) {
                $review->user->icon = 'icon/icon_user_2.svg';
            }

            if ($review->user->icon === 'icon/icon_user_2.svg') {
                $review->user->icon = Storage::url($review->user->icon);
            }
        }

        return view('review.reviews', compact('reviews', 'user', 'items', 'purchaseItems','reviewsAvg','totalReviews'));
    }
    }


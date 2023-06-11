<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function detail($id)
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

        $seller = User::where('id',$item->user_id)->first();


        return view('item.detail', compact('item', 'categories', 'mylist_items','comments', 'purchasedItemId','seller'));
    }
}

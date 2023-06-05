<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\Mylist;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $items = Item::where('item_name', 'LIKE', '%' . $searchTerm . '%')->get();
        $categoryItems = Category::where('category', 'LIKE', '%' . $searchTerm . '%')
            ->with('items')
            ->get();
        $categoryItems->each(function ($category) use (&$items) {
            $items = $items->merge($category->items);
        });
        $items = $items->unique();
        $user_id = Auth::id();
        $mylists = Mylist::select('mylists.id', 'mylists.user_id', 'mylists.item_id', 'items.price', 'items.image')
            ->leftJoin('items', 'items.id', '=', 'mylists.item_id')
            ->where('mylists.user_id', $user_id)
            ->get();
        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        return view('dashboard', compact('items', 'user_id', 'mylists', 'purchasedItemIds'));
    }
}

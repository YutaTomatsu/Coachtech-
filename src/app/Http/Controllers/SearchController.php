<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Mylist;
use App\Models\Purchase;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchStrings = preg_split('/[\s]+/u', $request->input('search'));

        $includeTerms = [];
        $excludeTerms = [];
        $orTerms = [];

        foreach ($searchStrings as $string) {
            if (mb_substr($string, 0, 1) === '-') {
                $excludeTerms[] = mb_substr($string, 1);
            } else if (mb_substr($string, 0, 1) === '+') {
                $includeTerms[] = mb_substr($string, 1);
            } else {
                $orTerms[] = $string;
            }
        }

        $itemQuery = Item::query();

        if (count($includeTerms) > 0) {
            $itemQuery->where(function ($query) use ($includeTerms) {
                foreach ($includeTerms as $term) {
                    $query->where(function ($query) use ($term) {
                        $query->where('item_name', 'LIKE', '%' . $term . '%')
                            ->orWhereHas('categories', function ($query) use ($term) {
                                $query->where('category', 'LIKE', '%' . $term . '%');
                            });
                    });
                }
            });
        }

        foreach ($excludeTerms as $term) {
            $itemQuery->where(function ($query) use ($term) {
                $query->where('item_name', 'NOT LIKE', '%' . $term . '%')
                    ->whereDoesntHave('categories', function ($query) use ($term) {
                        $query->where('category', 'LIKE', '%' . $term . '%');
                    });
            });
        }

        if (count($orTerms) > 0) {
            $itemQuery->where(function ($query) use ($orTerms) {
                foreach ($orTerms as $term) {
                    $query->orWhere(function ($query) use ($term) {
                        $query->where('item_name', 'LIKE', '%' . $term . '%')
                            ->orWhereHas('categories', function ($query) use ($term) {
                                $query->where('category', 'LIKE', '%' . $term . '%');
                            });
                    });
                }
            });
        }

        $items = $itemQuery->get();
        $user_id = Auth::id();
        $mylists = Mylist::select('mylists.id', 'mylists.user_id', 'mylists.item_id', 'items.price', 'items.image')
            ->leftJoin('items', 'items.id', '=', 'mylists.item_id')
            ->where('mylists.user_id', $user_id)
            ->get();
        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        return view('dashboard', compact('items', 'user_id', 'mylists', 'purchasedItemIds'));
    }
}

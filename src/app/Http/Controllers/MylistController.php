<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mylist;
use Illuminate\Support\Facades\Auth;

class MyListController extends Controller
{
    public function toggle(Request $request)
    {
        $item_id = $request->input('item_id');
        $user_id = Auth::id();

        $mylist = Mylist::where('item_id', $item_id)->where('user_id', $user_id)->first();

        if ($mylist) {
            $mylist->delete();
            $message = 'お気に入りを解除しました';
        } else {
            $mylist = new Mylist();
            $mylist->item_id = $item_id;
            $mylist->user_id = $user_id;
            $mylist->save();
            $message = 'お気に入りに追加しました';
        }

        $newCount = Mylist::where('item_id', $item_id)->count();

        return response()->json(['status' => 'success', 'message' => $message, 'newCount' => $newCount]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function showCommentForm($id)
    {
        $item = Item::select('items.id', 'items.user_id', 'items.item_name', 'items.price', 'items.image', 'items.about', 'conditions.condition')
            ->leftJoin('items_categories', 'items.id', '=', 'items_categories.item_id')
            ->leftJoin('categories', 'items_categories.category_id', '=', 'categories.id')
            ->leftJoin('items_conditions', 'items.id', '=', 'items_conditions.item_id')
            ->leftJoin('conditions', 'items_conditions.condition_id', '=', 'conditions.id')
            ->where('items.id', $id)
            ->first();

        $mylist_items = array();
        if (Auth::check()) {
            $mylist_items = Auth::user()->mylists()->pluck('item_id')->toArray();
        }

        $comments = Comment::where('item_id', $id)->get();

        foreach ($comments as $comment) {
            $user = User::select('users.name','icon')->where('users.id', $comment->user_id)->first();
            $comment->user_name = $user->name;
            if ($user) {
                $comment->user_icon = $user->icon ? $user->icon : 'icon/icon_user_2.svg';
            } else {
                $comment->user_icon = 'icon/icon_user_2.svg';
            }

            if ($comment->user_icon === 'icon/icon_user_2.svg') {
                $comment->user_icon = Storage::url($comment->user_icon);
            }
            $comment->is_seller = ($comment->user_id === $item->user_id);
        }

        $purchasedItemId = Purchase::pluck('item_id')->toArray();

        return view('comment.comment', compact('item', 'mylist_items', 'comments', 'purchasedItemId'));
    }

    public function comment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validateData = $request->validate([
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->item_id = $id;
        $comment->comment = $validateData['comment'];
        $comment->save();

        return redirect()->back()->with('success', 'コメントが送信されました');
    }

    public function delete($id)
    {
        $comment_id = $id;

        $comment = Comment::where('id', $comment_id)->first();

        if ($comment) {
            $comment->delete();
        }

        return redirect()->back()->with('success', 'コメントが削除されました');
    }
}

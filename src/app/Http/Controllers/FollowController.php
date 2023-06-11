<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Follow;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $user_id = $request->input('user_id');
        $seller_id = $request->input('seller_id');

        $follow = new Follow();
        $follow->user_id = $user_id;
        $follow->seller_id = $seller_id;
        $follow->save();

        return response()->json(['status' => 'success', 'message' => 'フォローしました！']);
    }

    public function unfollow(Request $request)
    {
        $user_id = $request->input('user_id');
        $seller_id = $request->input('seller_id');

        $follow = Follow::where('user_id', $user_id)->where('seller_id', $seller_id)->first();

        if ($follow) {
            $follow->delete();
            return response()->json(['status' => 'success', 'message' => 'フォローを解除しました！']);
        } else {
            return response()->json(['status' => 'error', 'messag' => 'フォローが見つかりませんでした。']);
        }
    }

    public function showFollowing ($id)
    {
        $following = Follow::with('user')->where('user_id', $id)->get();
        $isFollowing = null;


        foreach($following as $follow) {
        if (!$follow->icon) {
            $follow->icon = 'icon/icon_user_2.svg';
        }

        if ($follow->icon === 'icon/icon_user_2.svg') {
            $follow->icon = Storage::url($follow->icon);
        }
            if (Auth::check()) {
            $isFollowing = Follow::where('user_id', Auth::id())
                ->where('seller_id', $follow->seller_id)->get();
            }
    }

        return view('follow.following',compact('following','isFollowing'));
    }

    public function showFollower($id)
    {
        $followers = Follow::with('user')->where('seller_id', $id)->get();
        $isFollowing = null;

        foreach ($followers as $follower) {
            if (!$follower->icon) {
                $follower->icon = 'icon/icon_user_2.svg';
            }

            if ($follower->icon === 'icon/icon_user_2.svg') {
                $follower->icon = Storage::url($follower->icon);
            }

            if(Auth::check()){
            $isFollowing = Follow::where('user_id', Auth::id())
                ->where('seller_id', $follower->user_id)->exists();
            }

        }

        return view('follow.follower',compact('followers','isFollowing'));
    }
}

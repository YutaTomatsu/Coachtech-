<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Follow;
use App\Models\ShopFollow;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = $request->input('user_id');
        $seller_id = $request->input('seller_id');

        $follow = new Follow();
        $follow->user_id = $user_id;
        $follow->seller_id = $seller_id;
        $follow->save();

        return response()->json(['status' => 'success', 'message' => 'フォローしました！']);
    }

    public function shopFollow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = $request->input('user_id');
        $shop_id = $request->input('shop_id');

        $follow = new ShopFollow();
        $follow->user_id = $user_id;
        $follow->shop_id = $shop_id;
        $follow->save();

        return response()->json(['status' => 'success', 'message' => 'フォローしました！']);
    }

    public function unfollow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

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

    public function shopUnfollow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = $request->input('user_id');
        $shop_id = $request->input('shop_id');

        $follow = ShopFollow::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        if ($follow) {
            $follow->delete();
            return response()->json(['status' => 'success', 'message' => 'フォローを解除しました！']);
        } else {
            return response()->json(['status' => 'error', 'messag' => 'フォローが見つかりませんでした。']);
        }
    }

    public function showFollowing($id)
    {

        $following = Follow::with('user')->where('user_id', $id)->get();
        $isFollowing = null;


        foreach ($following as $follow) {
            if (!$follow->seller->icon) {
                $follow->seller->icon = 'user_icon/icon_user_5.png';
            }

            if ($follow->seller->icon === 'user_icon/icon_user_5.png') {
                $follow->seller->icon = Storage::disk('s3')->url($follow->seller->icon);
            }

            if (Auth::check()) {
                $isFollowing = Follow::where('user_id', Auth::id())
                    ->where('seller_id', $follow->seller_id)->get();
            }
        }

        return view('follow.following', compact('following', 'isFollowing'));
    }

    public function showFollower($id)
    {
        $followers = Follow::with('user')->where('seller_id', $id)->get();
        $isFollowing = null;

        foreach ($followers as $follower) {
            if (!$follower->user->icon) {
                $follower->user->icon = 'user_icon/icon_user_5.png';
            }

            if ($follower->user->icon === 'user_icon/icon_user_5.png') {
                $follower->user->icon = Storage::disk('s3')->url($follower->user->icon);
            }

            if (Auth::check()) {
                $isFollowing = Follow::where('user_id', Auth::id())
                    ->where('seller_id', $follower->user_id)->exists();
            }
        }

        return view('follow.follower', compact('followers', 'isFollowing'));
    }

    public function showShopFollower($id)
    {
        $followers = ShopFollow::with('user')->where('shop_id', $id)->get();
        $isFollowing = null;

        foreach ($followers as $follower) {
            if (!$follower->user->icon) {
                $follower->user->icon = 'user_icon/icon_user_5.png';
            }

            if ($follower->user->icon === 'user_icon/icon_user_5.png') {
                $follower->user->icon = Storage::disk('s3')->url($follower->user->icon);
            }

            if (Auth::check()) {
                $isFollowing = Follow::where('user_id', Auth::id())
                    ->where('seller_id', $follower->user_id)->exists();
            }
        }

        return view('follow.shop_follower', compact('followers', 'isFollowing'));
    }
}

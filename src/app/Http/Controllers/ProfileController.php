<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('mypage.profile', compact('profile','user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $user->name = $request->input('name');

        if ($request->hasFile('icon')) {
            $uploadedFile = $request->file('icon');
            $path = $uploadedFile->store('public/profiles');
            $user->icon = Storage::url($path);
        }

        $user->save();

        $profile = Profile::where('user_id', $user->id)->first();
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->postcode = $request->input('postcode');
        $profile->address = $request->input('address');
        $profile->build = $request->input('build');
        $profile->save();

        return redirect()->back()->with('status', 'プロフィールが更新されました');
    }
}

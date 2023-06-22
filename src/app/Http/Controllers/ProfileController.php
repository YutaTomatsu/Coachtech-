<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function showProfileForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->icon) {
            $user->icon = 'icon/icon_user_2.svg';
        }

        if ($user->icon === 'icon/icon_user_2.svg') {
            $user->icon = Storage::url($user->icon);
        }

        $profile = Profile::where('user_id', $user->id)->first();

        return view('mypage.profile', compact('profile', 'user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'postcode' => 'required|string|size:8|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'build' => 'nullable|string|max:255',
        ], [
            'name.string' => '名前は文字列で入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'postcode.string' => '郵便番号は文字列で入力してください。',
            'postcode.size' => '郵便番号は半角数字にハイフンを含めた形式で入力してください。',
            'postcode.regex' => '郵便番号は半角数字にハイフンを含めた形式で入力してください。',
            'address.string' => '住所は文字列で入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'build.string' => '建物名は文字列で入力してください。',
            'build.max' => '建物名は255文字以内で入力してください。',
        ]);

        $user->name = $validatedData['name'];

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

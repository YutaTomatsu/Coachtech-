<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserStaff;
use App\Models\Shop;

class UserEmailController extends Controller
{
    public function showStaff($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::where('id', $id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        $staffs = UserStaff::with('staff')->where('user_id',$shop->user_id)->get();

        return view('shop.staff', compact('shop','staffs','userStaff'));
    }

    public function create($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $shop = Shop::where('id',$id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.add_staff',compact('shop','userStaff'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $credentials = $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ], [
            'name.required' => '名前は必須です',
            'name.max' => '名前は最大20文字までです',
            'email.required' => 'メールアドレスは必須です',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは最低8文字必要です',
        ]);

        $credentials['password'] = Hash::make($credentials['password']); 

        $user = new User($credentials);
        $user->save();

        $user_id = new UserStaff();
        $user_id->user_id = Auth::id();
        $user_id->staff_id = $user->id;
        $user_id->save();

        return back()->with('success', 'スタッフが作成されました！');
    }

    public function staffDestroy(UserStaff $staff)
    {
        $staff->delete();
        DB::table('users')->where('id', $staff->staff_id)->delete();

        return redirect()->back()->with('success', 'スタッフを削除しました');
    }

    public function staffRedirect(){
        $user = Auth::user();

        $userId = UserStaff::where('staff_id',$user->id)->first();

        return redirect()->route('show-shop',['id'=>$userId->user_id]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEmail;
use App\Models\Shop;

class UserEmailController extends Controller
{
    public function showStaff($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::where('id', $id)->first();

        $staffs = UserEmail::where('user_id',Auth::id())->get();

        return view('shop.staff', compact('shop','staffs'));
    }
    public function showAddStaff(){
    }
    public function create($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $shop = Shop::where('id',$id)->first();

        return view('shop.add_staff',compact('shop'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $credentials = $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:user_emails,email'],
            'password' => ['required', 'min:8'],
        ]);

        $userEmail = new UserEmail($credentials);
        $userEmail->user_id = Auth::id();
        $userEmail->save();

        return back()->with('success', 'スタッフが作成されました！');
    }
}

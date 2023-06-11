<?php

namespace App\Http\Controllers;

use App\Models\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEmailController extends Controller
{
    public function create()
    {
        return view('shop.add_staff');
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'unique:user_emails,email'],
            'password' => ['required', 'min:8'],
        ]);

        $userEmail = new UserEmail($credentials);
        $userEmail->user_id = Auth::id();
        $userEmail->save();

        return back()->with('status', 'Email added successfully.');
    }
}

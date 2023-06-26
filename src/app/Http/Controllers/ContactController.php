<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShopMail;
use App\Models\Shop;
use App\Models\ShopEmail;
use App\Models\User;
use App\Models\UserStaff;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function showContactForm($id) {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::where('id',$id)->first();

        if (!$shop->shop_icon) {
            $shop->shop_icon = 'shops_icon/icon_default.svg';
        }

        if ($shop->shop_icon === 'shops_icon/icon_default.svg') {
            $shop->shop_icon = Storage::disk('s3')->url($shop->shop_icon);
        }

        $user = Auth::id();

        $contacts = ShopEmail::where('user_id', Auth::id())->where('shop_id', $id)->get();

        $contact = ShopEmail::where('user_id', Auth::id())->where('shop_id', $id)->first();

        return view('contact.contact',compact('contacts', 'contact', 'shop', 'user'));
    }

    public function sendEmail(Request $request,$id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'content' => 'required',
        ], [
            'content.required' => 'メッセージを入力してください。',
        ]);

        $shop = Shop::find($id);
        $user = $request->user();

        $shops_email = new ShopEmail;
        $shops_email->user_id = $user->id;
        $shops_email->shop_id = $shop->id;
        $shops_email->content = $request->content;
        $shops_email->sent_by = 'user';
        $shops_email->save();

        $emailToOwner = $shop->user->email;
        Mail::to($emailToOwner)->send(new ShopMail($request->content));

        $staffs = UserStaff::where('user_id', $user->id)->get();
        foreach ($staffs as $staff) {
            $staffUser = User::find($staff->staff_id);
            Mail::to($staffUser->email)->send(new ShopMail($request->content));
        }

        return redirect()->back()->with('success', 'Email sent successfully');
    }
}

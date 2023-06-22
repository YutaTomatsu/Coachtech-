<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShopMail;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopEmail;
use App\Models\UserStaff;

class ShopContactController extends Controller
{
    public function showContact($id)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shop = Shop::where('id', $id)->first();

        $doneContactIds = ShopEmail::where('status', 'done')->pluck('id')->toArray();

        $allUserIds = ShopEmail::where('shop_id', $id)->pluck('id')->toArray();

        $allShopEmails = ShopEmail::with('user')->whereIn('id', $allUserIds)->get();

        $users = clone $allShopEmails;

        $doneContactUserIds = [];
        foreach ($allShopEmails as $key => $shopEmail) {
            if (in_array($shopEmail->id, $doneContactIds)) {
                $doneContactUserIds[] = $shopEmail->user_id;
                unset($users[$key]);
            }
        }

        $doneContactUsers = $allShopEmails->whereIn('user_id', $doneContactUserIds)->whereNotIn('user_id', $users->pluck('user_id')->toArray());

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.shop_contacts', compact('shop', 'users', 'doneContactUsers','userStaff'));
    }





    public function showContactForm($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shopEmail = ShopEmail::where('id',$id)->first();

        $contacts = ShopEmail::where('user_id',$shopEmail->user_id)->where('shop_id',$shopEmail->shop_id)->get();

        $contactNotDone = ShopEmail::where('user_id', $shopEmail->user_id)->where('shop_id', $shopEmail->shop_id)->whereNull('status')->exists();

        $contact = ShopEmail::where('user_id',$shopEmail->user_id)->where('shop_id',$shopEmail->shop_id)->first();

        $shop = Shop::where('id', $shopEmail->shop_id)->first();

        $user = User::where('id', $shopEmail->user_id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('shop.shop_contact', compact('contacts','contact','contactNotDone','shop', 'user','userStaff'));
    }

    public function sendEmailToUser(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'content' => 'required',
        ], [
            'content.required' => 'メッセージを入力してください。',
        ]);

        $userEmail = ShopEmail::where('id',$id)->first();

        $shop = Shop::where('id',$userEmail->shop_id)->first();
        $user = User::where('Id',$userEmail->user_id)->first();

        $shops_email = new ShopEmail;
        $shops_email->user_id = $user->id;
        $shops_email->shop_id = $shop->id;
        $shops_email->content = $request->content;
        $shops_email->sent_by = 'shop';
        $shops_email->save();

        $emailToUser = $user->email;
        Mail::to($emailToUser)->send(new ShopMail($request->content));

        return redirect()->back();
    }

    public function shopContactDone($id)
    {

        $contact = ShopEmail::findOrFail($id);

        $userId = $contact->user_id;
        $shopId = $contact->shop_id;

        $messages = ShopEmail::where('user_id', $userId)->where('shop_id', $shopId)->get();

        foreach ($messages as $message) {
            $message->status = 'done';
            $message->save();
        }

        return redirect()->route('show-mails', ['id' => $shopId]);
    }

}

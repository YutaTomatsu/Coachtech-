<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopEmail;
use App\Models\UserStaff;

class AdminController extends Controller
{
    public function showShopContacts($id)
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

        return view('admin.admin_shop_contacts', compact('shop', 'users', 'doneContactUsers', 'userStaff'));
    }

    public function showShopUserContact($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $shopEmail = ShopEmail::where('id', $id)->first();

        $contacts = ShopEmail::where('user_id', $shopEmail->user_id)->where('shop_id', $shopEmail->shop_id)->get();

        $contactNotDone = ShopEmail::where('user_id', $shopEmail->user_id)->where('shop_id', $shopEmail->shop_id)->whereNull('status')->exists();

        $contact = ShopEmail::where('user_id', $shopEmail->user_id)->where('shop_id', $shopEmail->shop_id)->first();

        $shop = Shop::where('id', $shopEmail->shop_id)->first();

        $user = User::where('id', $shopEmail->user_id)->first();

        $userStaff = UserStaff::where('staff_id', Auth::id())->first();

        return view('admin.admin_shop_contact', compact('contacts', 'contact', 'contactNotDone', 'shop', 'user', 'userStaff'));
    }
}

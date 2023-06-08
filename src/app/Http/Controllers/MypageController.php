<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{
    public function create()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->icon) {
            $user->icon = 'icon/icon_user_2.svg';
        }

        if ($user->icon === 'icon/icon_user_2.svg') {
            $user->icon = Storage::url($user->icon);
        }

        $items = Item::where('items.user_id', Auth::id())
            ->get();

        $purchases = Purchase::where('user_id', $user->id)->get();

        $purchaseItems = collect();

        foreach ($purchases as $purchase) {
            $purchaseItem = Item::find($purchase->item_id);

            if ($purchaseItem) {
                $purchaseItems->push($purchaseItem);
            }
        }

        return view('mypage.mypage', compact('user', 'items', 'purchaseItems'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function showPurchageForm($id)
    {
        if(!Auth::user()){
            return redirect()->route('login');
        }

        $user = Auth::user();

        $item = Item::where('items.id', $id)->first();

        $addresses = Profile::where('user_id',Auth::id())->first();

        return view('purchase.purchase', compact('user','item','addresses'));
    }
}

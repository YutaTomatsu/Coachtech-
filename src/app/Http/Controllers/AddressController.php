<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Item;

class AddressController extends Controller
{
    public function showChangeAddressForm($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $item = Item::where('items.id', $id)->first();

        return view('purchase.change_address', compact('item'));
    }




    public function changeAddress(Request $request,$id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $item = Item::where('items.id', $id)->first();


        $addresses = Purchase::where('user_id', Auth::id())->where('item_id', $id)->first();
        if (!$addresses) {
            $addresses = new Purchase();
            $addresses->user_id = Auth::id();
        }

        $addresses->item_id = $id;
        $addresses->postcode = $request->input('postcode');
        $addresses->address = $request->input('address');
        $addresses->build = $request->input('build');

        return view('purchase.purchase',compact('user','item', 'addresses'))->with('status','発送先が変更されました');
    }
}
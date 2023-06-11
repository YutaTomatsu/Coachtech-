<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\PurchaseNotification;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Profile;

class PaymentController extends Controller
{
    public function showConvenienceForm(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();
        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];

        $request->session()->put('addresses', $addresses);

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $items->price,
            'currency' => 'jpy',
            'payment_method_types' => ['konbini'],
        ]);

        return view('purchase.payment', compact('user', 'items', 'addresses'), ['stripe' => $stripe, 'client_secret' => $paymentIntent->client_secret]);
    }

    public function showCardForm(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();

        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];

        $request->session()->put('addresses', $addresses);

        $paymentIntent = PaymentIntent::create([
            'amount' => $items->price,
            'currency' => 'jpy',
            'payment_method_types' => ['card'],
        ]);

        return view('purchase.payment', compact('user', 'items', 'addresses'), ['client_secret' => $paymentIntent->client_secret]);
    }


    public function showBankForm(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();
        $customer = \Stripe\Customer::create();
        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];

        $request->session()->put('addresses', $addresses);

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $items->price,
            'currency' => 'jpy',
            'customer' => $customer->id,
            'payment_method_types' => ['customer_balance'],
            'payment_method_data' => [
                'type' => 'customer_balance',
            ],
            'payment_method_options' => [
                'customer_balance' => [
                    'funding_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'type' => 'jp_bank_transfer',
                    ],
                ],
            ],
        ]);

        return view('purchase.payment', compact('user', 'addresses', 'items'), ['customer' => $customer, 'client_secret' => $intent->client_secret]);
    }

    public function success(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $addresses = $request->session()->get('addresses');

        $purchase = new Purchase();
        $purchase->user_id = Auth::id();
        $purchase->item_id = $id;
        $purchase->postcode = $addresses->postcode;
        $purchase->address = $addresses->address;
        $purchase->build = $addresses->build;
        $purchase->save();

        // 商品出品者の情報を取得
        $item = Item::where('id', $id)->first();
        $seller = User::where('id', $item->user_id)->first();

        // 出品者にメールを送信
        $data = [
            'seller_name' => $seller->name,
            'item_name' => $item->item_name,
            'price' => $item->price,
            'buyer_name' => Auth::user()->name,
            'buyer_email' => Auth::user()->email,
            'date' => $purchase->created_at,
        ];
        Mail::to($seller->email)->send(new PurchaseNotification($data));

        return view('purchase.success');
    }
}

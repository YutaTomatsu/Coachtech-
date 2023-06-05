<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;

class PaymentController extends Controller
{
    public function showConvenienceForm(Request $request,$id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();
        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $items->price,
            'currency' => 'jpy',
            'payment_method_types' => ['konbini'],
        ]);
dd($addresses);
        return view('purchase.payment', compact('user','items','addresses'), ['stripe' => $stripe, 'client_secret' => $paymentIntent->client_secret]);
    }

    public function showCardForm(Request $request, $id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();

        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];

        $paymentIntent = PaymentIntent::create([
            'amount' => $items->price,
            'currency' => 'jpy',
            'payment_method_types' => ['card'],
        ]);

        return view('purchase.payment', compact('user', 'items', 'addresses'), ['client_secret' => $paymentIntent->client_secret]);
    }


    public function showBankForm(Request $request,$id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $items = Item::where('items.id', $id)->first();
        $customer = \Stripe\Customer::create();
        $addresses = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'build' => $request->input('build'),
        ];
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

        return view('purchase.payment', compact('user','addresses','items'), ['customer' => $customer, 'client_secret' => $intent->client_secret]);
    }

    public function success($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Purchase::where('user_id', Auth::id())->where('item_id', $id)->first();
        if (!$address) {
            $address = new Purchase();
            $address->user_id = Auth::id();
            $address->item_id = $id;

            $profile = Profile::where('user_id', Auth::id())->first();
            if ($profile) {
                $address->postcode = $profile->postcode;
                $address->address = $profile->address;
                $address->build = $profile->build;
            } else {
                return redirect()->back()->with('error', '配送先が指定されていません。今回使用する配送先を指定してするか、プロフィールの住所を登録してください。');
            }

            $address->save();
        }

        return view('purchase.success');
    }


}

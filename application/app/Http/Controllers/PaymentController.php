<?php

namespace App\Http\Controllers;

use App\Models\DonateDetail;
use App\Models\DonateHistory;
use Exception;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    // Test

    function confirmPayment(Request $request){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $stripe->paymentIntents->confirm($request->paymentIntentId,
        [
            'return_url' => route('stripe.index'),
        ]);
        $paymentIntent = $stripe->paymentIntents->retrieve($request->paymentIntentId);
        return json_encode($paymentIntent);
    }

    function createPaymentIntents(Request $request){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 1999,  // Replace with your desired amount in cents
            'currency' => 'eur',
            'confirmation_method' => 'manual',
            'confirm' => true,
            'payment_method_data' => [
                'type' => 'card',
                'card' => [
                    'token' => $request->card_token,  // Card token from your frontend
                ],
            ],
            'return_url' => route('stripe.threeDS'),
        ]);

        return json_encode($paymentIntent);
    }

    //

    function createPaymentIntent(Request $request){
        $validate = Validator::make($request->all(), [
            'stripeToken' => ['required'],
            'card_number' => ['required'],
            'cvc' => ['required', 'numeric'],
            'expirey_date' => ['required'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'donates' => ['required', 'array', 'min:1'],
            'dedicate_this_donation' => ['max:40000'],
            // 'is_zakat' => ['boolean'],
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        $email = $request->email;
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $customers = $stripe->customers->all([
            "limit" => 10,
            "email" => $email,
        ]);

        foreach ($customers->autoPagingIterator() as $customer) {
            if ($customer->name == $request->first_name . " " . $request->last_name) {
                $customerId = $customer->id;
                break;
            }
        }

        if (isset($customerId)) {
            $customer = $stripe->customers->retrieve($customerId);
        } else {
            $customer = $stripe->customers->create(
                [
                    "email" => $request->email,
                    "name" => $request->first_name . " " . $request->last_name,
                    "source" => $request->stripeToken
                ]
            );
        }

        $total = 0;

        foreach ($request->donates as $donate) {
            $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
            $total += $subtotal;
        }

        if ($request->is_monthly == 'true') {
            $products = $stripe->products->all();
            $priceIds = [];
            foreach($products as $product ){
                $priceIds[$product->name] = $product->default_price;
            }

            $items = [];
            foreach ($request->donates as $donate) {
                array_push($items, [
                    'price' => $priceIds[$donate['donate_name']],
                    'quantity' => intval($donate['donate_count'])
                ]);
            }

            $paymentMethod = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'token' => $request->stripeToken,
                ],
            ]);

            $paymentMethod = $stripe->paymentMethods->attach(
                $paymentMethod->id,
                ['customer' => $customer->id]
            );

            $subscription = $stripe->subscriptions->create([
                'customer' => $customer->id,
                'items' => $items,
                'off_session' => true,
                'payment_behavior' => 'allow_incomplete',
                'payment_settings' => [
                    'save_default_payment_method' => 'on_subscription'
                ],
                'default_payment_method' => $paymentMethod->id,
                'expand' => ['latest_invoice.payment_intent'],
                "description" => $request->dedicate_this_donation ? "Double-Time Donate - " . $request->dedicate_this_donation : "Double-Time Donate",
            ]);
            $paymentIntent = $stripe->paymentIntents->retrieve($subscription->latest_invoice->payment_intent->id);
            if($paymentIntent->status === 'requires_action'){
                $paymentIntent->confirm([
                    'return_url' => route('stripe.threeDS'),
                ]);
            }
            return json_encode($paymentIntent);
        } else {

            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $total * 100,  // Replace with your desired amount in cents
                'currency' => 'eur',
                'confirmation_method' => 'manual',
                'confirm' => true,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,  // Card token from your frontend
                    ],
                ],
                'return_url' => route('stripe.threeDS'),
                'customer' => $customer->id,
                'description' => $request->dedicate_this_donation ? "One-Time Donate - " . $request->dedicate_this_donation : "One-Time Donate",
            ]);

            return json_encode($paymentIntent);
        }
    }

    function confirmPaymentIntent(Request $request){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $stripe->paymentIntents->confirm($request->paymentIntentId);
        $paymentIntent = $stripe->paymentIntents->retrieve($request->paymentIntentId);
        return json_encode($paymentIntent);
    }

    function createDonateHistory(Request $request){
        $validate = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'donates' => ['required', 'array', 'min:1'],
            'dedicate_this_donation' => ['max:40000'],
            'payment_intent_id' => ['required']
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        $total = 0;

        foreach ($request->donates as $donate) {
            $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
            $total += $subtotal;
        }

        $donateHistory = DonateHistory::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'customer_id' => '',
            'dedicate_this_donation' => $request->dedicate_this_donation,
            'is_zakat' => $request->is_zakat == 'true' ? 1 : 0,
            'is_monthly' => $request->is_monthly == 'true' ? 1 : 0,
            'price' => $total,
            'transaction_id' => $request->payment_intent_id,
        ]);

        foreach ($request->donates as $donate) {
            DonateDetail::create([
                'donate_history_id' => $donateHistory->id,
                'donate_name' => $donate["donate_name"],
                'donate_amount' => $donate["donate_amount"],
                'donate_count' => $donate["donate_count"],
            ]);
        }

        $data = [
            'status' => 'success',
            'msg' => '',
            'return_url' => route('home.thanks', $donateHistory->id)
        ];

        $request->session()->flash('success', 'You have donated successfully!');
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'stripeToken' => ['required'],
            'card_number' => ['required'],
            'cvc' => ['required', 'numeric'],
            'expirey_date' => ['required'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'donates' => ['required', 'array', 'min:1'],
            'dedicate_this_donation' => ['max:40000'],
            // 'is_zakat' => ['boolean'],
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        try {
            $email = $request->email;
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $customers = $stripe->customers->all([
                "limit" => 100,
                "email" => $email,
            ]);

            foreach ($customers->autoPagingIterator() as $customer) {
                if ($customer->name == $request->first_name . " " . $request->last_name) {
                    $customerId = $customer->id;
                    break;
                }
            }

            if (isset($customerId)) {
                $customer = $stripe->customers->retrieve($customerId);
            } else {
                $customer = $stripe->customers->create(
                    [
                        "email" => $request->email,
                        "name" => $request->first_name . " " . $request->last_name,
                        "source" => $request->stripeToken
                    ]
                );
            }

            $total = 0;

            foreach ($request->donates as $donate) {
                $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
                $total += $subtotal;
            }

            if ($request->is_monthly == 'true') {
                $items = [];
                foreach ($request->donates as $donate) {
                    array_push($items, [
                        'price' => $donate['donate_price_id'],
                        'quantity' => intval($donate['donate_count'])
                    ]);
                }

                $result = $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => $items,
                    'payment_behavior' => 'default_incomplete',
                    'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                    'expand' => ['latest_invoice.payment_intent'],
                    "description" => $request->dedicate_this_donation ? "Double-Time Donate - " . $request->dedicate_this_donation : "Double-Time Donate",
                ]);

                $invoice = $stripe->invoices->pay($result->latest_invoice->id, [
                    "source" => $customer->default_source
                ]);
            } else {

                $result = $stripe->charges->create([
                    "amount" => $total * 100,
                    "currency" => "usd",
                    "customer" => $customer->id,
                    "description" => $request->dedicate_this_donation ? "One-Time Donate - " . $request->dedicate_this_donation : "One-Time Donate",
                ]);
            }

            $donateHistory = DonateHistory::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'customer_id' => $customer->id,
                'dedicate_this_donation' => $request->dedicate_this_donation,
                'is_zakat' => $request->is_zakat == 'true' ? 1 : 0,
                'is_monthly' => $request->is_monthly == 'true' ? 1 : 0,
                'price' => $total,
                'transaction_id' => $result->id,
            ]);

            foreach ($request->donates as $donate) {
                DonateDetail::create([
                    'donate_history_id' => $donateHistory->id,
                    'donate_name' => $donate["donate_name"],
                    'donate_amount' => $donate["donate_amount"],
                    'donate_count' => $donate["donate_count"],
                ]);
            }

            $data = [
                'status' => 'success',
                'msg' => '',
                'return_url' => route('home.thanks', $donateHistory->id)
            ];

            $request->session()->flash('success', 'You have donated successfully!');
            return response()->json($data);
        } catch (CardException $th) {
            return response()->json(['status' => 'error', 'msg' => $th->getMessage()]);
        }
    }

    public function threeDS(){
        return view('stripe.3ds');
    }

    public function webHook(){

    }
}

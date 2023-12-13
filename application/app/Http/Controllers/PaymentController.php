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
    private $stripe;

    public function __construct(){
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
        return view('stripe.index');
    }

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

        $customers = $this->stripe->customers->all([
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
            $customer = $this->stripe->customers->retrieve($customerId);
        } else {
            $customer = $this->stripe->customers->create(
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
            $products = $this->stripe->products->all();
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

            $paymentMethod = $this->stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'token' => $request->stripeToken,
                ],
            ]);

            $paymentMethod = $this->stripe->paymentMethods->attach(
                $paymentMethod->id,
                ['customer' => $customer->id]
            );

            $subscription = $this->stripe->subscriptions->create([
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
            $paymentIntent = $this->stripe->paymentIntents->retrieve($subscription->latest_invoice->payment_intent->id);
            if($paymentIntent->status === 'requires_action'){
                $paymentIntent->confirm([
                    'return_url' => route('stripe.threeDS'),
                ]);
            }
            return json_encode($paymentIntent);
        } else {

            $paymentIntent = $this->stripe->paymentIntents->create([
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
        $this->stripe->paymentIntents->confirm($request->paymentIntentId);
        $paymentIntent = $this->stripe->paymentIntents->retrieve($request->paymentIntentId);
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

    public function threeDS(){
        return view('stripe.3ds');
    }

    public function webHook(Request $request){
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK');
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $this->handleStripeEvent($event);

        return response()->json(['success' => true]);
    }

    public function handleStripeEvent($event){
        switch ($event->type) {
            case 'invoice.paid':
                $invoice = $event->data->object;
                // $stripe->invoices->sendInvoice($invoice->id, []);
                // Log::info('Invoice {id} is paid. \r\n Detail: {data} \r\n', ['id' => $invoice->id, 'data' => json_encode($invoice)]);
                break;
            case 'invoice.payment_action_required':
                $invoice = $event->data->object;
                // $stripe->invoices->update($invoice->id, [
                //     'collection_method' => 'send_invoice'
                // ]);
                // $stripe->invoices->sendInvoice($invoice->id, []);
                // Log::info('Invoice {id} required payment. \r\n Detail: {data}', ['id' => $invoice->id, 'data' => json_encode($invoice)]);
                break;
            case 'invoice.sent':
                $invoice = $event->data->object;
                // Log::info('Invoice {id} is sent.', ['id' => $invoice->id]);
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }
}

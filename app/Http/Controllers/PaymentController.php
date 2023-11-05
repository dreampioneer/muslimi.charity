<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'phone_number' => ['numeric', 'digits:10'],
            'amount' => ['required', 'numeric'],
            'product_name' => ['required', 'numeric'],
            'count' => ['required', 'numeric'],
            'subAmount' => ['required', 'numeric'],
        ]);

        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create(
                [
                    "email" => $request->email,
                    "name" => $request->first_name . " " . $request->last_name,
                    "source" => $request->stripeToken
                ]
            );
            $result = $stripe->charges->create([
                "amount" => 100 * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Donate",
            ]);
        } catch (CardException $th) {
            throw new Exception("There was a problem processing your payment", 1);
        }

        return back()->withSuccess('Payment done.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Exception;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe.index');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'product_name' => ['required','max:255'],
            'count' => ['required', 'numeric'],
            'sub_amount' => ['required', 'numeric'],
            'stripeToken' => ['required']
        ]);

        $subAmount = floatval($request->sub_amount);
        $count = intval($request->count);

        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
        }

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
                "amount" => $subAmount * $count * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Donate",
            ]);

            DonateHistory::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'product_name' => $request->product_name,
                'count' => $request->count,
                'price' => $request->sub_amount,
                'transaction_id' => $result->id,
            ]);

            return back()->with(['success' => 'Payment done.']);
        } catch (CardException $th) {
            return back()->with(['error' => $th->getMessage()])->withInput();
        }
    }
}

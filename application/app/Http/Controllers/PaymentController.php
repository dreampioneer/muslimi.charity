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
            'dedicate_this_donation' => ['max:255'],
            // 'is_zakat' => ['boolean'],
        ]);

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

            $total = 0;

            foreach ($request->donates as $donate) {
                $subtotal = intval($donate['donate_count']) * floatval($donate['donate_amount']);
                $total += $subtotal;
            }

            $result = $stripe->charges->create([
                "amount" => $total * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Donate",
            ]);

            $donateHistory = DonateHistory::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'dedicate_this_donation' => $request->dedicate_this_donation,
                'is_zakat' => $request->is_zakat == 'true' ? 1: 0,
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

            $request->session()->flash('success', 'You have donated successfully!');
            return response()->json(['status' => 'success', 'msg' => '']);
        } catch (CardException $th) {
            return response()->json(['status' => 'error', 'msg' => $th->getMessage()]);
        }
    }
}

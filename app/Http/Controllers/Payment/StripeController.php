<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sample Product',
                    ],
                    'unit_amount' => 5000, // $50.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $session_id = $request->get('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::retrieve($session_id);

        if ($session && $session->payment_status == 'paid') {
            return "Payment successful! Thank you.";
        }

        return "Payment failed or not completed.";
    }

    public function cancel()
    {
        return "Payment canceled.";
    }


}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function StripeOrder(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51M94oTD09WSqQPMxtckjmD914q0wU8Ep8xXUAMQ542Zi3llWcGzKZXwveVNptBiMKsuDFCph6B74aF7uXcnFPyst00uIYMxBbs');

        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
        'amount' => 999*100,
        'currency' => 'usd',
        'description' => 'Bahadır Önal Multi Vendor E-Commerce',
        'source' => $token,
        'metadata' => ['order_id' => '6735'],
        ]);

        dd($charge);
    }
}

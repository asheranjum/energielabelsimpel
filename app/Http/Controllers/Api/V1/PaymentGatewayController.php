<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentGatewayController extends Controller
{
    //

    public function index(Request $request)
    {

        return $request->all();
        // // Create an instance of the Simplify gateway
        // $gateway = Omnipay::create('Simplify');
        // $gateway->setApiKey('YOUR_API_KEY');

        // // Set the payment parameters
        // $parameters = [
        //     'amount' => '10.00',
        //     'currency' => 'USD',
        //     'card' => [
        //         'number' => $request->input('card_number'),
        //         'expiryMonth' => $request->input('card_exp_month'),
        //         'expiryYear' => $request->input('card_exp_year'),
        //         'cvv' => $request->input('card_cvc'),
        //     ],
        // ];

        // // Send the purchase request
        // $response = $gateway->purchase($parameters)->send();

        // // Process the response
        // if ($response->isSuccessful()) {
        //     // Payment approved
        //     return 'Payment approved. Transaction ID: ' . $response->getTransactionReference();
        // } else {
        //     // Payment declined
        //     return 'Payment declined. Error message: ' . $response->getMessage();
        // }
    }
}

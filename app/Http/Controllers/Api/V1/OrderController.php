<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ShippingPostcode;
use App\Order;
use App\OrderDetail;
use App\OrderBilling;
use App\OrderShipping;
use App\PaymentMethod;
use App\OrderPayment;
use App\OrderStatus;
use App\ShippingService;
use App\Customer;
use App\UserDetail;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// use Omnipay\Omnipay;
// use Kimoslim\Simplify\Simplify;
// use Kimoslim\Simplify\SimplifyException;
// use Simplify;
// require_once './app/Payment/Simplify.php';
// use App\Payment\Simplify;
use Stripe;
use DB;
use Carbon\Carbon;
use PDF;


class OrderController extends Controller
{


	public function index(Request $request)
	{
		// return $request->token		;

		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

		$PaymentObj =  Stripe\Charge::create([
			"amount" => 100 * 100,
			"currency" => "usd",
			"source" => $request->token['id'],
			"description" => "Test payment from itsolutionstuff.com."
		]);


		// return  $PaymentObj;

		$dataSave = new OrderPayment();
		$dataSave->email = 'asheranjum50@gmail.com';
		$dataSave->payment_obj =  $PaymentObj;
		$dataSave->save();


		$result = ApiHelper::success('Payment Done', $dataSave);

		return response()->json($result, 200);

		// Simplify::$publicKey = 'lvpb_OGU5YzEwMDgtOTFmYy00YzdiLTljZjQtYmI0MzQyMWU4ZWU1';
		// Simplify::$privateKey = 'emPEE04hKJl1ZX/rwgPbEfLiQ4TPItTM9uUCo+57YKN5YFFQL0ODSXAOkNtXTToq';
		// $simplify = new Simplify();

		// dd($simplify);

		// $payment = Simplify::createPayment(array(
		// 	"card" => array(
		// 		"number" => "5555555555554444",
		// 		"expMonth" => 11,
		// 		"expYear" => 99,
		// 		"cvc" => "123"
		// 	),
		// 	'amount' => '1000',
		// 	'description' => 'prod description',
		// 	'currency' => 'USD'
		// ));
		// if ($payment->paymentStatus == 'APPROVED') {

		// 	echo "Payment approved\n";
		// }
	}
	// public function index(Request $request)
	// {

	//     // return $request->all();
	//     // Create an instance of the Simplify gateway
	//     $gateway = Omnipay::create('Simplify');
	//     $gateway->setApiKey('YOUR_API_KEY');

	//     // Set the payment parameters
	//     $parameters = [
	//         'amount' => '10.00',
	//         'currency' => 'USD',
	//         'card' => [
	//             'number' => $request->input('card_number'),
	//             'expiryMonth' => $request->input('card_exp_month'),
	//             'expiryYear' => $request->input('card_exp_year'),
	//             'cvv' => $request->input('card_cvc'),
	//         ],
	//     ];

	//     // Send the purchase request
	//     $response = $gateway->purchase($parameters)->send();

	//     // Process the response
	//     if ($response->isSuccessful()) {
	//         // Payment approved
	//         return 'Payment approved. Transaction ID: ' . $response->getTransactionReference();
	//     } else {
	//         // Payment declined
	//         return 'Payment declined. Error message: ' . $response->getMessage();
	//     }
	// }


	// public function index()
	// {

	// 	$products = Product::published()->with('category')->with('subcategory')->get();

	// 	$result = ApiHelper::success('All Products', $products);
	// 	return response()->json($result, 200);
	// }


	public function getZipCodePrice($code)
	{

		$getShippingPrice = ShippingPostcode::published()->where('code', $code)->first();

		$result = ApiHelper::success('Shipping Cost', $getShippingPrice);

		return response()->json($result, 200);
	}

	public  function getPaymentMethod()
	{

		$getShippingPrice = PaymentMethod::published()->get();

		$result = ApiHelper::success('Payment Methods', $getShippingPrice);

		return response()->json($result, 200);
	}

	public  function getShippingMethod()
	{

		$getShippingPrice = ShippingService::published()->get();

		$result = ApiHelper::success('Shipping Methods', $getShippingPrice);

		return response()->json($result, 200);
	}

	public function StripPayment(Request $request)
	{
		// return $request->all();

		Stripe\Stripe::setApiKey('sk_test_XSlCax7Th2VCbSEPo4utXZUB00eyckwoo1');

		$PaymentObj =  Stripe\Charge::create([
			"amount" =>  $request->formData['total_price'],
			"currency" => "usd",
			"source" => $request->token['id'],
			"description" => "Test payment from radio nostalgiez"
		]);


		$dataSave = new OrderPayment();
		$dataSave->email = $request->formData['email'];
		$dataSave->order_no = $request->formData['order_id'];
		$dataSave->payment_method = 'Stripe';
		$dataSave->payment_obj = json_encode(json_encode($PaymentObj));
		$dataSave->save();


		DB::table('orders')
		->where('order_no', $request->formData['order_id'])
		->update(['payment_id' => $dataSave->id]);


		$result = ApiHelper::success('Payment Done', $dataSave);

		return response()->json($result, 200);
	}

	public function MakePayment(Request $request)
	{
		// return $request->all();

		$dataSave = new OrderPayment();
		$dataSave->email = $request->email;
		$dataSave->order_no = $request->order_id;
		$dataSave->payment_obj =  json_encode(json_encode($request->paymentObj));
		$dataSave->payment_method = 'Commonwealth bank';
		$dataSave->save();

		DB::table('orders')
		->where('order_no', $request->order_id)
		->update(['payment_id' => $dataSave->id]);

		$result = ApiHelper::success('Payment Done', $dataSave);

		return response()->json($result, 200);
	}
	
       

	public function getOrder(Request $request)
	{


		// if ($request->create_account == 'on' && $request->password != "" ) {


		// 	$validator = Validator::make($request->all(), [
		// 		'firstname' => 'required',
		// 		'lastname' => 'required',
		// 		'email' => 'required|email|unique:users',
		// 		'password' => 'required|min:6',
		// 		// 'c_password' => 'required|same:password',
		// 	]);


		// 	if ($validator->fails()) {
		// 		$result = ApiHelper::validation_error('Validation Error', $validator->errors()->all());
		// 		return response()->json($result, 422);
		// 	}


		// 	$user = Customer::create([
		// 		'name' => $request->first_name . ' ' . $request->last_name,
		// 		'email' => $request->email,
		// 		'role_id' => '3',
		// 		'password' => Hash::make($request->password),

		// 	]);

		// 	$userBasic = new  UserDetail();

		// 	$userBasic->first_name = $request->first_name;
		// 	$userBasic->last_name = $request->last_name;
		// 	$userBasic->email = $request->email;
		// 	$userBasic->phone = $request->phone;
		// 	$userBasic->user_id = $user->id;
		// 	$userBasic->save();


		// 	$token = $user->createToken('authToken')->plainTextToken;
		// }

		$order  = new Order();
		$latestOrder = Order::orderBy('created_at', 'DESC')->first();
		$order->order_no = str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
		$order->shipping_method =  $request->shipping_method;
		$order->shipping_id =  1;
		$order->user_id =  $request->user_id;
		$order->payment_id =  $request->payment_id;
		$order->payment_method =  $request->payment_method;
		$order->product = $request->products;
		$order->amount =  $request->total_price;
		$order->tax_amount =  $request->total_price;
		$order->coupon_code =  $request->total_price;
		$order->sub_total =  $request->total_price;
		$order->status =  $request->status;
		$order->is_confirmed =  $request->is_confirmed;
		$order->is_finished =  $request->is_confirmed;
		$order->save();
        
        $shippingDiff = $request->isShippingDif;
        
        if($shippingDiff == true)
        {
    		$OrderShipping  = new OrderShipping();
    		$OrderShipping->email =  $request->email_ship;
    		$OrderShipping->order_no =  str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
    		$OrderShipping->first_name =   $request->first_name_ship;
    		$OrderShipping->last_name =   $request->last_name_ship;
    		$OrderShipping->phone =  $request->phone_ship;
    		$OrderShipping->country =  $request->country_ship;
    		$OrderShipping->state =  $request->state_ship;
    		$OrderShipping->city =  $request->city_ship;
    		$OrderShipping->address =  $request->address_ship;
    		$OrderShipping->company_name =  $request->company_name_ship;
    		$OrderShipping->order_note =  $request->order_note;
    		$OrderShipping->postal_code = $request->postal_ship;
    		$OrderShipping->type =  111;
    		$OrderShipping->save();
    		
    		
    		$OrderBilling  = new OrderBilling();
    		$OrderBilling->email =  $request->email;
    		$OrderBilling->order_no =  str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
    		$OrderBilling->first_name =   $request->first_name;
    		$OrderBilling->last_name =   $request->last_name;
    		$OrderBilling->phone =  $request->phone;
    		$OrderBilling->country =  $request->country;
    		$OrderBilling->state =  $request->state;
    		$OrderBilling->city =  $request->city;
    		$OrderBilling->address =  $request->address_1 . ' ' . $request->street_address_1 == '' ? '' :  $request->street_address_2;
    		$OrderBilling->company_name =  $request->company_name;
    		$OrderBilling->order_note =  $request->order_note;
    		$OrderBilling->postal_code = $request->postal;
    		$OrderBilling->type =  111;
    		$OrderBilling->save();
        }
        else
        {
            
            $OrderBilling  = new OrderBilling();
    		$OrderBilling->email =  $request->email;
    		$OrderBilling->order_no =  str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
    		$OrderBilling->first_name =   $request->first_name;
    		$OrderBilling->last_name =   $request->last_name;
    		$OrderBilling->phone =  $request->phone;
    		$OrderBilling->country =  $request->country;
    		$OrderBilling->state =  $request->state;
    		$OrderBilling->city =  $request->city;
    		$OrderBilling->address =  $request->address_1 . ' ' . $request->street_address_1 == '' ? '' :  $request->street_address_2;
    		$OrderBilling->company_name =  $request->company_name;
    		$OrderBilling->order_note =  $request->order_note;
    		$OrderBilling->postal_code = $request->postal;
    		$OrderBilling->type =  111;
    		$OrderBilling->save();
        
    		$OrderShipping  = new OrderShipping();
    		$OrderShipping->email =  $request->email;
    		$OrderShipping->order_no =  str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
    		$OrderShipping->first_name =   $request->first_name;
    		$OrderShipping->last_name =   $request->last_name;
    		$OrderShipping->phone =  $request->phone;
    		$OrderShipping->country =  $request->country;
    		$OrderShipping->state =  $request->state;
    		$OrderShipping->city =  $request->city;
    		$OrderShipping->address =  $request->address_1 . ' ' . $request->street_address_1 == '' ? '' :  $request->street_address_2;
    		$OrderShipping->company_name =  $request->company_name;
    		$OrderShipping->order_note =  $request->order_note;
    		$OrderShipping->postal_code = $request->postal;
    		$OrderShipping->type =  111;
    		$OrderShipping->save();
		
        }


		




		DB::table('order_payments')
			->where('id', $request->payment_id)
			->update(['order_no' => str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT)]);


		// $details = [
		// 	'title' => 'Order Confirmation',
		// 	'body' => 'Your order has beeen placed',
		// 	'order_id' => str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT),
		// 	'itemsCount' =>  2,
		// 	'products' =>  $request->products,
		// 	'status' =>  $request->status,
		// 	'total' =>  $request->total_price
		// ];


		$details = [
			'first_name' =>  $request->first_name. ' ' .$request->last_name,
			'title' => 'Thank You For Your Order!',
			'body' => 'Thanks for your order. It’s on-hold until we confirm that payment has been received. In the meantime, here’s a reminder of what you ordered:',
			'order_id' => str_pad($latestOrder == null ? 0 : $latestOrder->id + 1, 8, "0", STR_PAD_LEFT),
			'created_date' => $order->created_at,
			'itemsCount' =>  '2',
			'products' =>  json_decode($request->products),
			'status' =>  $request->status,
			'total' =>  $request->total_price,
			'delivery_name' =>  $request->first_name. ' ' .$request->last_name,
			'delivery_company' =>  $request->company_name,
			'delivery_address_1' =>  $request->street_address_1 ,
			'delivery_address_2' =>  $request->city .' '.$request->state. ' ' .$request->postal,
			'delivery_contact_no' =>  $request->phone,
			'delivery_email' =>  $request->email,
			'expected_delivery' =>  '10/07/2023',
		];
		

		\Mail::to($request->email)->send(new \App\Mail\OrderConfirmMail($details));

		// dd($request->all());

		// $products = Product::published()->with('category')->with('subcategory')->where('id', $productId)->first();

		$result = ApiHelper::success('product-details', $order);

		// return view('email.orderConfirm',compact('details'));
		return response()->json($result, 200);
	}

	public function updateORder(Request $request)
	{
        
        $getBillingInfo =  OrderBilling::where('order_no', $request->orderId)->firstOrFail();
        $getShippingInfo =  OrderShipping::where('order_no', $request->orderId)->firstOrFail();
        $getOrderDetail =  Order::where('order_no', $request->orderId)->firstOrFail();
        $getOrderPayment =  OrderPayment::where('order_no', $request->orderId)->firstOrFail();
        

        $details = [
            
            'billing_info' => [
                'delivery_name' => $getBillingInfo->first_name . ' ' . $getBillingInfo->last_name,
                'company_name' => $getBillingInfo->company_name,
                'address' => $getBillingInfo->address,
                'city' => $getBillingInfo->city,
                'country' => $getBillingInfo->country,
                'state' => $getBillingInfo->state,
                'postal' => $getBillingInfo->postal_code,
                'contact_no' => $getBillingInfo->phone,
                'email' => $getBillingInfo->email,
            ],
            'shipping_info' => [
                'delivery_name' => $getShippingInfo->first_name . ' ' . $getShippingInfo->last_name,
                'delivery_company' => $getShippingInfo->company_name,
                'delivery_address_1' => $getShippingInfo->address,
                'delivery_address_2' => $getShippingInfo->city . ' ' . $getShippingInfo->state . ' ' . $getShippingInfo->postal_code,
                'delivery_contact_no' => $getShippingInfo->phone,
                'delivery_email' => $getShippingInfo->email,
                'state' => $getShippingInfo->state,
                 'city' => $getShippingInfo->city,
                   'postal' => $getShippingInfo->postal_code,
                'country' => $getShippingInfo->country,
                'expected_delivery' => Carbon::now()->addWeek()->format('m/d/Y'), // Add 1 week to the current date
            ],
            'payment_info' => [
                'title' => 'Thank You For Your Order!',
                'body' => 'Thanks for your order. It’s on-hold until we confirm that payment has been received. In the meantime, here’s a reminder of what you ordered:',
                'itemsCount' => '2',
                'order_id' => $request->orderId,
                'payment_method' => $getOrderPayment->payment_method,
                'shipping_method' => $getOrderDetail->shipping_method,
                'status' => $getOrderDetail->status,
                'tax' => number_format($getOrderDetail->tax_amount, 2),
                'subtotal' => number_format($getOrderDetail->sub_total, 2),
                'total' => number_format($getOrderDetail->amount, 2),
                'created_date' => $getOrderPayment->created_at,
            ],
            'products' => json_decode($getOrderDetail->product),
        ];
          	
    		$updateOrder =  Order::where('order_no', $request->orderId)->firstOrFail();
		$updateOrder->status = $request->status;
		$updateOrder->save();
		
        //  	return response()->json($details, 200);
        \Mail::to($request->email)->send(new \App\Mail\PaymentComplete($details));
        
		$result = ApiHelper::success('product-details', $updateOrder);

		// return view('email.orderConfirm',compact('details'));
		return response()->json($result, 200);
	}

	public function getOrderDetails($orderCode)
	{

		$orderData = Order::where('order_no', $orderCode)->with('orderBilling')->with('orderShipping')->with('OrderPayments')->first();
		// $orderDetail = OrderDetail::where('order_no','#'.$orderCode)->first();

		// $responeData['order'] = $orderData;
		// $responeData['order-details'] = $orderDetail;

		$result = ApiHelper::success('order details', $orderData);

		return response()->json($result, 200);
	}

	public function getOrderStatus()
	{

		$orderData = OrderStatus::all();

		$result = ApiHelper::success('order details', $orderData);

		return response()->json($result, 200);
	}
	
	
	public function initPayment(Request $request)
	{
        $merchantId = env('AFTERPAY_MERCHANT_ID');
        $secretKey = env('AFTERPAY_SECRET_KEY');
        $environment = env('AFTERPAY_ENVIRONMENT', 'sandbox');
        $apiUrl;
        

        if ($environment === 'sandbox') {
            $apiUrl = 'https://api-sandbox.afterpay.com/v2/checkouts';
        } else {
            $apiUrl = 'https://api.afterpay.com/v2/checkouts';
        }

        // Assuming the entire payload is sent in the request body from the frontend
        $payload = $request->all();
   
        $response = Http::withBasicAuth($merchantId, $secretKey)->post($apiUrl, $payload);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        } else {
            // Log error details for debugging
            \Log::error('Afterpay order creation failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create Afterpay order',
                'errors' => $response->json(),
            ], $response->status());
        }
	}
	
	public function successPayment(Request $request)
    {
        // // The order ID or token is typically passed as a query parameter
        // $orderId = $request->query('orderId');
    
        // // Retrieve the order from your database
        // $order = Order::where('order_id', $orderId)->firstOrFail();
    
        // // Update the order status to 'completed' or a similar status in your database
        // $order->status = 'completed';
        // $order->save();
    
        // // Optionally, store transaction details for future reference
        // Transaction::create([
        //     'order_id' => $order->id,
        //     'status' => 'completed',
        //     // Include other relevant details
        // ]);
    
        // Return a response or redirect the user as needed
        return response()->json(['message' => 'Payment successful and order completed.']);
        }

    public function failurePayment(Request $request)
    {
        // // Handle the failure case, similar to the success handler but marking the order as cancelled or failed
        // $orderId = $request->query('orderId');
        // $order = Order::where('order_id', $orderId)->firstOrFail();
        // $order->status = 'failed';
        // $order->save();
    
        // Return a response or redirect the user as needed
        return response()->json(['message' => 'Payment failed or was cancelled.']);
    }
    
    
     	private function captureAfterpayPayment($token, $merchantReference)
        {
            
        
          $merchantId = env('AFTERPAY_MERCHANT_ID');
          $secretKey = env('AFTERPAY_SECRET_KEY');
          $environment = env('AFTERPAY_ENVIRONMENT', 'sandbox');
        
          $apiUrl;
            

            if ($environment === 'sandbox') {
                $apiUrl = 'https://api-sandbox.afterpay.com/v2/payments/capture';
            } else {
                $apiUrl = 'https://api.afterpay.com/v2/payments/capture';
            }
        
                    
            $payload = [
                'token' => $token,
                'merchantReference' => $merchantReference
            ];
        
     
        $response = Http::withBasicAuth($merchantId, $secretKey)->post($apiUrl, $payload);
        
        
            return $response->json();
        }

	
		public function MakePaymentAfterPay(Request $request)
    	{
	

		$dataSave = new OrderPayment();
		$dataSave->email = $request->email;
		$dataSave->order_no = $request->order_id;
		$dataSave->payment_obj =  json_encode(json_encode($request->paymentObj));
		$dataSave->payment_method = 'Afterpay';
		$dataSave->save();

		DB::table('orders')
		->where('order_no', $request->order_id)
		->update(['payment_id' => $dataSave->id]);
		
		
	    // Capture the payment using Afterpay API
	      
        $token = $request->paymentObj['orderToken']; // Assuming the token is part of the payment object
        $merchantReference = $request->paymentObj['order_id']; // Using the order ID as the merchant reference
    
    
    
        $response = $this->captureAfterpayPayment($token, $merchantReference);

        // Save the API response in the payment object
        $dataSave->payment_obj = json_encode(json_encode($response));
        $dataSave->save();
        
    

		$result = ApiHelper::success('Payment Done', $dataSave);

		return response()->json($result, 200);
	}
	

	public function generateInvoice($orderID)
	{
	
		
		    
        $getBillingInfo =  OrderBilling::where('order_no', $orderID)->first();
        $getShippingInfo =  OrderShipping::where('order_no', $orderID)->first();
        $getOrderDetail =  Order::where('order_no', $orderID)->first();
        $getOrderPayment =  OrderPayment::where('order_no', $orderID)->first();
		
        
		

        $details = [
            
            'billing_info' => [
                'delivery_name' => $getBillingInfo->first_name . ' ' . $getBillingInfo->last_name,
                'company_name' => $getBillingInfo->company_name,
                'address' => $getBillingInfo->address,
                'city' => $getBillingInfo->city,
                'country' => $getBillingInfo->country,
                'state' => $getBillingInfo->state,
                'postal' => $getBillingInfo->postal_code,
                'contact_no' => $getBillingInfo->phone,
                'email' => $getBillingInfo->email,
            ],
            'shipping_info' => [
                'delivery_name' => $getShippingInfo->first_name . ' ' . $getShippingInfo->last_name,
                'delivery_company' => $getShippingInfo->company_name,
                'delivery_address_1' => $getShippingInfo->address,
                'delivery_address_2' => $getShippingInfo->city . ' ' . $getShippingInfo->state . ' ' . $getShippingInfo->postal_code,
                'delivery_contact_no' => $getShippingInfo->phone,
                'delivery_email' => $getShippingInfo->email,
                'state' => $getShippingInfo->state,
                 'city' => $getShippingInfo->city,
                   'postal' => $getShippingInfo->postal_code,
                'country' => $getShippingInfo->country,
                'expected_delivery' => Carbon::now()->addWeek()->format('m/d/Y'), // Add 1 week to the current date
            ],
            'payment_info' => [
                'title' => 'Thank You For Your Order!',
                'body' => 'Thanks for your order. It’s on-hold until we confirm that payment has been received. In the meantime, here’s a reminder of what you ordered:',
                'itemsCount' => '2',
                'order_id' =>  $orderID ,
                'payment_method' =>  $getOrderPayment && $getOrderPayment->payment_method,
                'shipping_method' => $getOrderDetail->shipping_method,
                'status' => $getOrderDetail->status,
                'tax' => number_format($getOrderDetail->tax_amount, 2),
                'subtotal' => number_format($getOrderDetail->sub_total, 2),
                'total' => number_format($getOrderDetail->amount, 2),
                'transaction_id' => $getOrderPayment && $getOrderPayment->id ,
                'transaction_date' => $getOrderPayment && $getOrderPayment->created_at,
            ],
            'products' => json_decode($getOrderDetail->product),
        ];
        
        // return  $details;
    	
		
		$pdf = PDF::loadView('invoices.order', compact('details'));
		// return $pdf->stream('order-invoice.pdf');

		return $pdf->download('order-invoice.pdf');

		// return view('invoices.order', compact('details'));
	}

}

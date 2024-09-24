<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Order;
use App\OrderBilling;
use App\OrderShipping;
use App\OrderPayment;

use Carbon\Carbon;
use PDF;

class PaymentComplete extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     
     
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
         return $pdf->output();
	}
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //      $status = $this->details['payment_info']['order-status'];
         
    //      if($status == 'Completed')
    //      {
    //         return new Envelope(
    //             subject: 'Payment is Completed',
    //         );
    //      }
    //      else
    //      {
    //           return new Envelope(
    //         subject: 'Payment is Uncomplete',
    //     );
    //      }
       
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'email.paymentComplete',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
     
    // public function attachments()
    // {
    //     $pdfContent = $this->SendgenerateInvoice($this->details['payment_info']['order_id']);
    
    //     return [
    //         ['data' => $pdfContent, 'name' => 'invoice.pdf', 'mime' => 'application/pdf'],
    //     ];
    // }
    
    
    public function build()
{
    $pdfContent = $this->generateInvoice($this->details['payment_info']['order_id']);

    return $this->subject($this->details['payment_info']['title'])
                ->view('email.paymentComplete')
                ->attachData($pdfContent, 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
}
    
}

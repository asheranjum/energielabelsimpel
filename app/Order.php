<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ProductCategory;
use App\ProductSubCategory;
use App\OrderBilling; 
use App\OrderShipping; 
use App\OrderPayment; 
use App\PaymentMethod; 
use Carbon\Carbon;
class Order extends Model
{



	// public $timestamps = false;


	
	// public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($order) {
    //         $order->order_no =  str_pad($order->id, 6, '0', STR_PAD_LEFT);
    //     });
    // }
	

	public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }




      public function orderDetails()
    {
        return $this->hasOne(OrderBilling::class, 'order_no', 'order_no');
    }

      public function orderBilling()
    {
        return $this->hasOne(OrderBilling::class, 'order_no', 'order_no');
    }
      public function orderShipping()
    {
        return $this->hasOne(OrderShipping::class, 'order_no', 'order_no');
    }


      public function OrderPayments()
    {
        return $this->hasOne(OrderPayment::class, 'id', 'payment_id')->select(['id','order_no','payment_method']);
    }

      public function PaymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method')->select('name');
    }



  


    // public function getCreatedAtAttribute($value)
    // {
    //   return Carbon::parse($value)->diffForHumans();
    // }
	
}



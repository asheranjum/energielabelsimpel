<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class OrderStatus extends Model
{
    
    protected $table = 'order_status';

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }

}

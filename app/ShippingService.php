<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ShippingService extends Model
{
 
    
    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ShippingPostcode extends Model
{
    

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }
    
}

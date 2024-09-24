<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AttributeType;

class Attribute extends Model
{



    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }


    public function type()
    {
        return $this->belongsTo(AttributeType::class, 'type_id');
    }
    
}

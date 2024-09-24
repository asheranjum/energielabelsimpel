<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attribute;

class AttributeType extends Model
{
     
    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'type_id');
    }




}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductSubCategory extends Model
{
    


    public function category_sub_products()
    {
        return $this->hasMany(Product::class,'sub_category_id')->with('category')->with('subcategory');
    }


    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }

}

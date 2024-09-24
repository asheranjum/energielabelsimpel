<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;
class Tag extends Model
{
    

    public function products()
    {
        return $this->belongsToMany(Product::class, 'tag_product_pivot', 'tag_id', 'product_id')->with('category')->where('status','PUBLISHED');
    }

    

}

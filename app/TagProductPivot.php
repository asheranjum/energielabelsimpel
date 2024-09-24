<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Tag;


class TagProductPivot extends Model
{
    protected $table = 'tag_product_pivot';

    public function getProducts(){
   
        return $this->belongsTo(Product::class, 'product_id' , 'id');
    }


    public function getTags(){
   
        return $this->belongsTo(Tag::class, 'tag_id' , 'id');
    }
    
}

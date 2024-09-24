<?php

namespace App\Models;

// App\Models\ProductCategory

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\ProductSubCategory;
use App\AttributeTypePivot;
use Carbon\Carbon;

class ProductCategory extends Model
{
    use HasFactory;


    public function products()
    {
        return $this->hasMany(Product::class)->where('status','PUBLISHED');
    }



    public function category_products()
    {
        return $this->hasMany(Product::class,'category_id');
    }


    public function getSubCategory()
    {
        return $this->hasMany(ProductSubCategory::class,'category_id')->where('status','PUBLISHED');
    }


    public function attributePivots()
    {
        return $this->hasMany(AttributeTypePivot::class, 'product_category_id')->where('status','PUBLISHED');;
    }


    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }

    public function scopeIdDescending($query)
{
        return $query->orderBy('created_at','DESC');
}  

    // public function parent()
    // {
    //     return $this->belongsTo(ProductCategory::class, 'category_id');
    // }

    // public function children()
    // {
    //     return $this->hasMany(ProductCategory::class, 'category_id');
    // }


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y h:i A');
    }

}

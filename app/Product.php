<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ProductCategory;
use App\ProductSubCategory;
use App\TagProductPivot;
use App\Tag;
use Carbon\Carbon;
class Product extends Model
{



// 	public $timestamps = false;

	public function city()
	{
		return $this->belongsTo('App\City');
	}


	public static function categoryIdRelationship($id)
	{

		return
			self::where('products.id', '=', $id)
			->select('products.category_id', 'products.sub_category_id')
			->join('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
			->join('product_categories', 'products.category_id', '=', 'product_categories.id')
			->first();
	}


	public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }



	public function category()
	{
		return $this->belongsTo(ProductCategory::class);
	}

	public function subcategory()
	{
		return $this->belongsTo(ProductSubCategory::class);
	}


	
	public function orders()
	{
		return $this->hasMany(Order::class);
	}
	
	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->diffForHumans();
	}


	public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_product_pivot', 'product_id', 'tag_id');
    }
	
	
}




// {
//     "model": "App\\Models\\ProductCategory",
//     "name": "category_id",
//     "route": "api.v1.dropdown",
//     "display": "Select Category",
//     "placeholder": "Select a Category",
//     "key": "id",
//     "label": "name",
//     "dependent_dropdown": [
//         {
//             "model": "App\\ProductSubCategory",
//             "name": "sub_category_id",
//             "display": "Sub Category",
//             "placeholder": "Select a Sub Category",
//             "key": "id",
//             "label": "name",
//             "where": "category_id"
//         }
//     ],
//     "validation": {
//         "rule": "required|gt:0"
//     }
// }

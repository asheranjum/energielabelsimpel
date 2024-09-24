<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\ProductCategory;
use App\ProductSubCategory;
use Carbon\Carbon;
class OrderDetail extends Model
{


	/**
	 *
	 *	return [
	 *		'city_id' => xxx,
	 *		'state_id' => yyy
	 *		'country_id' => zzz
	 *	]
	 *
	 */


	public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }


	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->diffForHumans();
	}
}

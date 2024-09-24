<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class OrderBilling extends Model
{
    use HasFactory;


    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }


	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->diffForHumans();
	}

}

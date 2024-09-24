<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\ProductModule;
use App\ModulesAttribute;
use App\ModulesAttributeValue;

class ProductCustomization extends Model
{
 
 	public function module_3d()
	{
		return $this->belongsTo(ProductModule::class,'module_id','id');
	}   
	
	
//  	public function module_attributes()
// 	{
// 		return $this->hasMany(ModulesAttribute::class,'id','attribute_id');
// 	}   
	
	
	
	public function module_attributes_values()
    {
        return $this->belongsToMany(ModulesAttributeValue::class, 'CustomizationAttributeValues', 'product_customization_id', 'modules_attribute_value_id');
    }
    
    
	public function module_attributes()
    {
        return $this->belongsToMany(ModulesAttribute::class, 'CustomizationAttributeValues');
    }
}

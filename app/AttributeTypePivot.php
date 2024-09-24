<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attribute;
use App\AttributeType;

class AttributeTypePivot extends Model
{
    protected $table =  "attribute_type_pivot";


    public function getAttributeType(){
   
        return $this->belongsTo(AttributeType::class, 'attribute_type_id' , 'id');

    }
    public function attributeType(){
   
        return $this->belongsTo(AttributeType::class, 'attribute_type_id' , 'id');

    }


 




}

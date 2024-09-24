<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Slider extends Model
{
    
    use Translatable;
    protected $translatable = ['title', 'caption'];

    public function save(array $options = [])
    {
        if(!isset($this->user_id)){
            $this->user_id = Auth::user()->id;
        }
        parent::save();
    }

}

<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Playlist extends Model
{
    

    use Translatable;
    protected $translatable = ['interpreter', 'composition'];

    public function save(array $options = [])
    {
        if(!isset($this->user_id)){
            $this->user_id = Auth::user()->id;
        }
        parent::save();
    }

}

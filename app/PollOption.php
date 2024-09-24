<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PollOption extends Model
{
    protected $fillable = ['text']; // Ensure 'text' is fillable if you're using mass assignment

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'option_id');
    }


       // Accessor to get votes count
    public function getVotesCountAttribute()
    {
        return $this->votes->count();
    }

}

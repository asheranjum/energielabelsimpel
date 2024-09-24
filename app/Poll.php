<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PollOption;

class Poll extends Model
{
    

    protected static function booted()
    {
        static::deleting(function ($poll) {
            // Before the poll is deleted, delete all associated options
            $poll->options()->delete();
        });
    }

        // Define the relationship to options
        public function options()
        {
            return $this->hasMany(PollOption::class);
        }

}

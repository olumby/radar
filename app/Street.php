<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    /**
     * Get tweets that include the street.
     */
    public function streets()
    {
        return $this->belongsToMany('App\Street');
    }
}

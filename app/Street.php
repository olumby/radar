<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'point' => 'array',
    ];

    /**
     * Get tweets that include the street.
     */
    public function streets()
    {
        return $this->belongsToMany('App\Street');
    }
}

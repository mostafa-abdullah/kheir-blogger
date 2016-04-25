<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable = ['location', 'city'];

    protected $table = 'locations';

    public function volunteers()
    {
        return $this->belongsToMany('App\User', 'volunteer_locations');
    }
}

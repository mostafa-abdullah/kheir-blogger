<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable = ['location', 'city'];

    protected $table = 'locations';

    /*
     * users return all users which have this location in their available location
     */
    public function users(){

        return $this->belongsToMany('App\User');

    }
}

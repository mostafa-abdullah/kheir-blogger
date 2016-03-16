<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'name', 'description', 'timing','location','required_contact_info','needed_membership'
    ];

    /**
    * Get the users attending an event
    */
    public function users()
    {
      return $this->belongsToMany('App\User');
    }

}

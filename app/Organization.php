<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
class Organization extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password','bio','slogan','phone','location',
    ];

    /**
     * Get list of Users subscribed to an Organization.
     */
    public function subscribers()
    {
      return $this->belongsToMany("App\User",
        "volunteers_subscribe_organizations")->withTimestamps();

    }
}

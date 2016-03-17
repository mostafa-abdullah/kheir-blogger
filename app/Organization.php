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

    /**
     * Get list of Users sent recommendations to an Organization.
     */
    public function usersSentRecommendations()
    {
      return $this->belongsToMany("App\User",
        "volunteers_recommend_organizations")->withTimestamps();

    }
}

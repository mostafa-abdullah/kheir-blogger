<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get list of Organizations which the user is subscribed to.
     */
    public function subscribedOrganizations()
    {
      return $this->belongsToMany("App\Organization",
        "volunteers_subscribe_organizations")->withTimestamps();

    }

    /**
     * Subscribe to an Organization.
     */
    public function subscribe($org_id)
    {
      return $this->subscribedOrganizations()->attach($org_id);

    }

    /**
     * Unsubscribe from an Organization.
     */
    public function unsubscribe($org_id)
    {
      return $this->subscribedOrganizations()->detach($org_id);

    }

}

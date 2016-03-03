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
    public function subscribe($organization_id)
    {
      return $this->subscribedOrganizations()->attach($organization_id);

    }

    /**
     * Unsubscribe from an Organization.
     */
    public function unsubscribe($organization_id)
    {
      return $this->subscribedOrganizations()->detach($organization_id);

    }

    /**
     * Get list of Organizations which the user sent recommendations to.
     */
    public function recommendedOrganizations()
    {
        return $this->belongsToMany("Organization",
            "volunteers_recommend_organizations")->withTimestamps();

    }

    /**
     * send recommendation to an Organization.
     */
    public function recommend($organization_id)
    {
        return $this->recommendedOrganizations()->attach($organization_id);

    }

    /**
     * Delete recommendation sent to Organization.
     */
    public function deleteRecommendation($organization_id)
    {
        return $this->recommendedOrganizations()->detach($organization_id);

    }

}

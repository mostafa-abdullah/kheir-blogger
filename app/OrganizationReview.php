<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationReview extends Model
{
    protected $fillable = ['review' , 'rate'];

    protected $table = 'organization_reviews';

    public function user(){

        return $this->belongsTo('App\user');
    }

    public function organization(){

        return $this->belongsTo('App\Organization');
    }

    public function reportingUsers()
    {
        return $this->belongsToMany('App\User', 'organization_review_reports')->withTimestamps();
    }
}

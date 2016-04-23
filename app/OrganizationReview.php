<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationReview extends Model
{
    use SoftDeletes;

    protected $fillable = ['review', 'rating'];

    protected $table = 'organization_reviews';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function reportingUsers()
    {
        return $this->belongsToMany('App\User', 'organization_review_reports', 'review_id', 'user_id')
                    ->withTimestamps();
    }
}

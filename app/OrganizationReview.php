<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrganizationReview extends Model
{
    use SoftDeletes;

    protected $fillable = ['review', 'rate'];

    protected $table = 'organization_reviews';

    protected $dates = ['deleted_at'];

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

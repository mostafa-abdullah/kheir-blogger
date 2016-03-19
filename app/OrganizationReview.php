<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationReview extends Model
{
    
    protected $table = 'organization_reviews';

    protected $fillable = ['review' , 'rate'] ;
}

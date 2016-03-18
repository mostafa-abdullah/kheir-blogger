<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization_Review extends Model
{
    //
    protected $table = 'organization_reviews';

    protected $fillable = ['review' , 'rate'] ;
}

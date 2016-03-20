<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'organization_reviews';

    //I think the id of user and organization should be fillable //Hossam
    protected $fillable = ['user_id' , 'organization_id' , 'review' , 'rate'];


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_Review extends Model
{
    //
    protected $table = 'event_reviews';

    protected $fillable = ['review' , 'rate'] ;

}

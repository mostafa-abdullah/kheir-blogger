<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPost extends Model
{
    protected $table = 'event_posts';
    protected $fillable = ['event_id','organization_id','title','description'];
}

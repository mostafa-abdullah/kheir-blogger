<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eventPost extends Model
{
    protected $table = 'event_posts';
    protected $fillable = ['event_id','organization_id','name','description'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPost extends Model
{
    protected $fillable = ['title','description'];

    protected $table = 'event_posts';

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}

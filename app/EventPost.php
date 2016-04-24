<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','description'];
    protected $table = 'event_posts';

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}

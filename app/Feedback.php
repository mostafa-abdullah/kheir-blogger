<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['subject' , 'message'];

    public function volunteer()
    {
        return $this->belongsTo('App\User');
    }
}

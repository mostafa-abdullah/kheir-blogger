<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'message', 'seen', 'user_id'
    ];

    public function scopeUnseen($query)
    {
        return $query->where('seen', false);
    }

    public function user()
    {
        return $this->belongsTo('App\User','users');
    }
}

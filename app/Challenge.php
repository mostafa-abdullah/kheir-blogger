<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = ['events'];


    public function user(){

        return $this->belongsTo('App\User');
    }
}

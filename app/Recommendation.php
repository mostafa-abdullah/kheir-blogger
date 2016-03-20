<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = ['recommendation'];

    public function user(){

        return $this->belongsTo('App\User');
    }

    public function organization(){
        
        return $this->belongsTo('App\Organization');
    }
}

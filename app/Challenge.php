<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    protected $fillable = ['events'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function attendedEvents()
    {
        return $this->user()->first()->attendedEvents()->year($this->year);
    }

    public function scopeCurrentYear($query)
    {
    	$query->where('year', Carbon::now()->year);
    }

    public function scopePreviousYears($query)
    {
    	$query->where('year', '<' , Carbon::now()->year);
    }
}

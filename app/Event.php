<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'description', 'timing','location','required_contact_info','needed_membership'
    ];

    public static function createEvent($request)
    {
    	# code...
    	print_r($request->all());
    }
}

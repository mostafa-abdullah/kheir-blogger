<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Organization extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];
}

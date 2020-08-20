<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //
    protected $fillable = [
        'username', 'password', 'last_name', 'first_name', 'image_path'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}


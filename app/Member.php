<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    //
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'verification_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
 
    public function verified()
    {
        return $this->email_verified_at;
    }
}

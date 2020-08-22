<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    //
    protected $fillable = [
        'first_name', 'last_name', 'address','email', 'password', 'verification_token'
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

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}

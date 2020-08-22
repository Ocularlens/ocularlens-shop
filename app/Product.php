<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'price', 'image_path', 'quantity'
    ];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}

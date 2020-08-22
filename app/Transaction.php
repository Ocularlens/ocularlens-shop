<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'total', 'charge', 'refund'
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transaction', 'transaction_id', 'product_id')
            ->withPivot(['quantity']);
    }
}

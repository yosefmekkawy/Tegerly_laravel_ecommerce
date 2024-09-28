<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','quantity','cart_id'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}

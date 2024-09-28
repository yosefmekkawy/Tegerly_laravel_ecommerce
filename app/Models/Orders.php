<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'ordered_by', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }
}

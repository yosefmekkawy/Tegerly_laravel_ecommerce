<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category',
        'published_by'];

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class,'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class,'category');

    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = [
        'name', 
        'description',
        'cover_image',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withTimestamps();
    }
}

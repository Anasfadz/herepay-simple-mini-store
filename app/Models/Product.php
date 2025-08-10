<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'short_description',
        'description',
        'price',
        'image',
        'variants',
        'quantity'
    ];

    protected $casts = [
        'variants' => 'array',
    ];
}


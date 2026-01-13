<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'admin_products';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'sizes',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

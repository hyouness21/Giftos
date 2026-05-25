<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price_usd', 'image_url', 'category_id', 'in_stock'];
    protected $casts    = ['in_stock' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

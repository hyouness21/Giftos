<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'items', 'total_usd', 'total_lbp', 'status'];

    protected $casts = ['items' => 'array'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'name',
        'total_price',
        'order_created',
        'order_updated',
        'json',
    ];

    protected $casts = [
        'name' => 'string',
        'total_price' => 'number',
        'order_created' => 'datetime',
        'order_updated' => 'datetime',
        'json' => 'string'
    ];
}

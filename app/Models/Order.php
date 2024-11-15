<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',         
        'client',
        'phone',
        'loading_place',
        'unloading_place',
        'loading_date',
        'unloading_date',
        'cargo_type',
        'grain_quantity',
        'price_per_ton',  
        'transport_cost',
        'notes',
    ];
}

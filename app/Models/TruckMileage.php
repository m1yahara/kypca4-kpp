<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckMileage extends Model
{
    use HasFactory;

    protected $fillable = [
        'truck_id',
        'date',
        'mileage',
        'fuel_cost_per_100km',
        'amortization_cost_per_100km',
        'total_fuel_cost',
        'total_amortization_cost',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}

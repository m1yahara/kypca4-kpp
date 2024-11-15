<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truck extends Model
{
    use HasFactory;

    protected $table = 'trucks';
    
    protected $fillable = [
        'user_id', 'brand', 'model', 'year', 'license_plate', 'load_capacity', 'condition'
    ];

    public function trailers()
    {
        return $this->hasMany(Trailer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mileages()
    {
        return $this->hasMany(TruckMileage::class);
    }

    
}
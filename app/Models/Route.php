<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Route extends Model
{
    use HasFactory;

    // Дозволяємо масове заповнення полів
    protected $fillable = [
        'user_id',
        'start_location',
        'end_location',
        'distance',
        'duration',
        'coordinates'
    ];

    // Тип поля coordinates як масив (JSON)
    protected $casts = [
        'coordinates' => 'json'
    ];

    // Відношення до користувача
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

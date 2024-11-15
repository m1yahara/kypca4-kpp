<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('start_location'); // Початкова адреса
            $table->string('end_location'); // Кінцева адреса
            $table->float('distance'); // Відстань у км
            $table->float('duration'); // Тривалість у хвилинах
            $table->json('coordinates'); // Координати маршруту у форматі GeoJSON
            $table->timestamps(); // Поля created_at і updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

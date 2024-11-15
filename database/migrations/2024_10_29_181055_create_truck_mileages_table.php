<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('truck_mileages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('mileage'); // Загальний пробіг
            $table->decimal('fuel_cost_per_100km', 15, 2); // Витрати на паливо на 100 км
            $table->decimal('amortization_cost_per_100km', 15, 2); // Амортизація на 100 км
            $table->decimal('total_fuel_cost', 15, 2); // Загальні витрати на паливо
            $table->decimal('total_amortization_cost', 15, 2); // Загальні витрати на амортизацію
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_mileages');
    }
};

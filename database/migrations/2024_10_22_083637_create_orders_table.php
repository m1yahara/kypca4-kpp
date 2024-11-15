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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('client');
            $table->string('phone');
            $table->string('loading_place');
            $table->string('unloading_place');
            $table->date('loading_date');
            $table->date('unloading_date');
            $table->string('cargo_type');
            $table->decimal('grain_quantity', 8, 2);
            $table->decimal('price_per_ton', 8, 2);
            $table->decimal('transport_cost', 8, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

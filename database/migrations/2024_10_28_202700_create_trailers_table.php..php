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
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Прив'язка до користувача
            $table->unsignedBigInteger('truck_id')->nullable(); // Може бути прив'язаний до вантажівки або залишатись null
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('license_plate')->unique();
            $table->string('type');
            $table->decimal('load_capacity', 8, 2);
            $table->string('condition');
            $table->timestamps();
        
            // Встановлюємо зв'язок із таблицею користувачів
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Встановлюємо зв'язок із таблицею вантажівок
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};

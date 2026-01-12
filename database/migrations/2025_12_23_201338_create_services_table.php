<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('name_ar');
            $table->string('name_en');
            $table->decimal('price', 10, 2);
            $table->string('price_unit')->default('fixed');
            $table->integer('capacity')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
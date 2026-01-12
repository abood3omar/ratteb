<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city');
            $table->string('location_link')->nullable();
            $table->boolean('is_freelance')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
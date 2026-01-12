<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occasion_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('category_occasion_type', function (Blueprint $table) {
            $table->foreignId('occasion_type_id')
                  ->constrained('occasion_types')
                  ->onDelete('cascade');

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->unique(['occasion_type_id', 'category_id']);

            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_occasion_type');
        Schema::dropIfExists('occasion_types');
    }
};
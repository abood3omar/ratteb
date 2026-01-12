<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('package_service', function (Blueprint $table) {
            $table->foreignId('package_id')
                  ->constrained('packages')
                  ->onDelete('cascade');

            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');

            $table->unique(['package_id', 'service_id']);
            $table->index('service_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_service');
        Schema::dropIfExists('packages');
    }
};
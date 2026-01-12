<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('package_id')
                  ->constrained('packages')
                  ->onDelete('cascade');

            $table->date('date');
            $table->text('notes')->nullable();
            $table->decimal('total_price', 10, 2);

            $table->string('status')
                  ->default('pending')
                  ->comment('pending, approved, rejected, completed, cancelled');

            $table->timestamps();
            $table->index('user_id');
            $table->index('package_id');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }

};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('guest_count')->nullable();
            $table->string('delivery_type')->default('pickup')->comment('pickup or delivery');
            $table->text('address')->nullable();
            $table->text('extra_details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['guest_count', 'delivery_type', 'address', 'extra_details']);
        });
    }
};
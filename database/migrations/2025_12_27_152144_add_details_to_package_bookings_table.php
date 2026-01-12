<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_bookings', function (Blueprint $table) {
            $table->string('delivery_type')->default('pickup')->comment('pickup or delivery');
            $table->text('address')->nullable();
            $table->text('extra_details')->nullable();
            $table->integer('guest_count')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('package_bookings', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'address', 'extra_details', 'guest_count']);
        });
    }
};
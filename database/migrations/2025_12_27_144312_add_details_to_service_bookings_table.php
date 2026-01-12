<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration لإضافة حقول التوصيل والتفاصيل إلى جدول service_bookings
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->string('delivery_type')->nullable()->comment('pickup or delivery');
            $table->text('address')->nullable();
            $table->string('flower_type')->nullable();
            $table->integer('guest_count')->nullable();
        });
    }

    /**
     * التراجع عن الـ Migration
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'address', 'flower_type', 'guest_count']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    $tables = ['bookings', 'package_bookings', 'service_bookings'];

    foreach ($tables as $tableName) {
        Schema::table($tableName, function (Blueprint $table) {
            $table->string('payment_receipt')->nullable(); 
            $table->decimal('deposit_amount', 10, 2)->nullable();
        });
    }
}

public function down()
{
    $tables = ['bookings', 'package_bookings', 'service_bookings'];
    foreach ($tables as $tableName) {
        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn(['payment_receipt', 'deposit_amount']);
        });
    }
}
};

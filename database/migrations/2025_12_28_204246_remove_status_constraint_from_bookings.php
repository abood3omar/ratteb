<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['bookings', 'package_bookings', 'service_bookings'];

        foreach ($tables as $tableName) {
            // 1. البحث عن اسم القيد (Constraint Name) في SQL Server
            // هذا الاستعلام بجيب اسم القيد الخاص بعمود status لهذا الجدول
            $constraintName = DB::scalar("
                SELECT name
                FROM sys.check_constraints
                WHERE parent_object_id = OBJECT_ID('$tableName')
                AND definition LIKE '%status%'
            ");

            // 2. إذا وجدنا القيد، نحذفه
            if ($constraintName) {
                DB::statement("ALTER TABLE $tableName DROP CONSTRAINT $constraintName");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
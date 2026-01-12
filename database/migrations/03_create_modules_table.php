<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration لإنشاء جدول modules
 * يحتوي على: معرف الموديول، اسم الموديول، والتوقيتات
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {

            $table->id('ModuleID');
            $table->string('ModuleName')->unique();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
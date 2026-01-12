<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id('EntityID');
            $table->string('EntityName')->unique();
            $table->unsignedBigInteger('ModuleID');
            $table->foreign('ModuleID')
                  ->references('ModuleID')
                  ->on('modules')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
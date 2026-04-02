<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('function_module', function (Blueprint $table) {
            $table->id(); 
            $table->integer('function_id')->unique();
            $table->string('function_name');
            $table->text('description')->nullable();
            $table->integer('module_id');
            $table->string('module_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('function_module');
    }
};
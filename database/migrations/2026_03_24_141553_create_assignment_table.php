<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment', function (Blueprint $table) {
            $table->id();
            
            
            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->onDelete('cascade');

            
            $table->foreignId('function_module_id')
                  ->constrained('function_module')
                  ->onDelete('cascade');

            
            $table->string('permission'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment');
    }
};
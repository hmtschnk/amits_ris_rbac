<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('ui_labels', function (Blueprint $table) {
            $table->id();
            $table->string('label_key', 100);
            $table->string('language', 10)->default('en');
            $table->string('label_text', 255);
            $table->timestamps();

            
            // One label per language
            $table->unique(['label_key', 'language'], 'ui_labels_key_language_unique');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ui_labels');
    }
};

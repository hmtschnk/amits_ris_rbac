<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('patient_referrals', function (Blueprint $table) {
        $table->string('xray_type_id')->nullable()->after('age');
        $table->date('birthdate')->nullable()->after('xray_type_id');
        $table->string('patient_email')->nullable()->after('birthdate');
        $table->string('referring_dr')->nullable()->after('patient_email');
        $table->text('clinical_reason')->nullable()->after('referring_dr');
    });
    }

    public function down()
    {
        Schema::table('patient_referrals', function (Blueprint $table) {
            $table->dropColumn(['xray_type_id', 'birthdate', 'patient_email', 'referring_dr', 'clinical_reason']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('online_appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('online_appointments', 'age')) $table->string('age', 50);
            if (!Schema::hasColumn('online_appointments', 'district_id')) $table->integer('district_id')->nullable();
            if (!Schema::hasColumn('online_appointments', 'upazila_id')) $table->integer('upazila_id')->nullable();
            if (!Schema::hasColumn('online_appointments', 'union_id')) $table->integer('union_id')->nullable();
            if (!Schema::hasColumn('online_appointments', 'referer_doctor')) $table->string('referer_doctor')->nullable();
            if (!Schema::hasColumn('online_appointments', 'remarks')) $table->string('remarks')->nullable();
        });

        if (!Schema::hasColumn('patient_info', 'doctor_id')) {
            Schema::table('patient_info', function (Blueprint $table) {
                $table->bigInteger('doctor_id')->unsigned()->nullable();
            });
        }

        if (!Schema::hasColumn('patient_medicine', 'patient_prescription_id')) {
            Schema::table('patient_medicine', function (Blueprint $table) {
                $table->bigInteger('patient_prescription_id')->unsigned()->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_appointments', function (Blueprint $table) {
            //
        });
    }
};

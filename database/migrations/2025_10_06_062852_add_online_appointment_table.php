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
            $table->string('age', 50);
            $table->integer('district_id')->nullable();
            $table->integer('upazila_id')->nullable();
            $table->integer('union_id')->nullable();
            $table->string('referer_doctor')->nullable();
            $table->string('remarks')->nullable();
        });

        Schema::table('patient_info', function (Blueprint $table) {
            $table->bigInteger('doctor_id')->unsigned()->nullable();
        });
        Schema::table('patient_medicine', function (Blueprint $table) {
            $table->bigInteger('patient_id')->unsigned()->nullable();
        });
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

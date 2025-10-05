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
        Schema::table('patient_info', function (Blueprint $table) {
            $table->integer('upazila_id')->nullable();
            $table->integer('union_id')->nullable();
            $table->string('referer_doctor')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_info', function (Blueprint $table) {
            //
        });
    }
};

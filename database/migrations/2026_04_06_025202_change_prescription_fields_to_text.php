<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients_prescription_record', function (Blueprint $table) {
            $table->text('complaints')->nullable()->change();
            $table->text('on_examination')->nullable()->change();
            $table->text('pastHistory')->nullable()->change();
            $table->text('drugHistory')->nullable()->change();
            $table->text('investigation')->nullable()->change();
            $table->text('diagnosis')->nullable()->change();
            $table->text('treatmentPlan')->nullable()->change();
            $table->text('operationNote')->nullable()->change();
            $table->text('advice')->nullable()->change();
            $table->text('nextPlan')->nullable()->change();
            $table->text('hospitalizations')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('patients_prescription_record', function (Blueprint $table) {
            $table->string('complaints')->nullable()->change();
            $table->string('on_examination')->nullable()->change();
            $table->string('pastHistory')->nullable()->change();
            $table->string('drugHistory')->nullable()->change();
            $table->string('investigation')->nullable()->change();
            $table->string('diagnosis')->nullable()->change();
            $table->string('treatmentPlan')->nullable()->change();
            $table->string('operationNote')->nullable()->change();
            $table->string('advice')->nullable()->change();
            $table->string('nextPlan')->nullable()->change();
            $table->string('hospitalizations')->nullable()->change();
        });
    }
};

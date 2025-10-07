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
        Schema::create('patients_prescription_record', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned()->nullable();
            $table->date('visit_date');
            $table->string('complaints')->nullable();
            $table->string('on_examination')->nullable();
            $table->string('pastHistory')->nullable();
            $table->string('drugHistory')->nullable();
            $table->string('investigation')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('treatmentPlan')->nullable();
            $table->string('operationNote')->nullable();
            $table->string('advice')->nullable();
            $table->string('nextPlan')->nullable();
            $table->string('hospitalizations')->nullable();
            $table->date('next_visit_date')->nullable();

            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 2 = Inactive, 0 = Delete');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->ipAddress('created_ip')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->ipAddress('updated_ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_prescription_record');
    }
};

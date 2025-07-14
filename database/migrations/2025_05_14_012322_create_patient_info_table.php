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
        Schema::create('patient_info', function (Blueprint $table) {
            $table->bigIncrements('id'); // BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->bigInteger('patient_id')->unsigned()->unique(); // Unique, non-auto-incrementing
            $table->string('name', 300)->nullable();
            $table->string('age',100)->nullable();
            $table->string('gender')->comment('1=Male, 2=Female, 3=Other')->nullable();
            $table->integer('district_id')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('religion')->nullable();
            $table->integer('occupation')->nullable();
            $table->integer('education_status')->nullable();
            $table->integer('monthly_income')->nullable();
            $table->string('pt_contact_number', 50)->nullable();
            $table->string('attendent_contact_number', 50)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('hospital_reg_no', 50)->nullable();
            $table->tinyInteger('unit')->nullable();
            $table->string('ward_no', 50)->nullable(); // Corrected from word_no
            $table->string('bed_no', 50)->nullable();
            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable(); // Made nullable
            $table->integer('diagnosis')->nullable();
            $table->string('present_illness', 100)->nullable();
            $table->string('past_illness', 100)->nullable();
            $table->string('comorbidities', 100)->nullable();
            $table->text('family_history')->nullable();
            $table->text('drug_history')->nullable();
            $table->text('previous_drug_history')->nullable();
            $table->text('clinical_findings')->nullable();
            $table->text('cbc_result')->nullable();
            $table->text('s_electrolytes')->nullable();
            $table->text('s_creatinine')->nullable();
            $table->text('s_urea')->nullable();
            $table->text('lft')->nullable();
            $table->text('s_bilirubin')->nullable();
            $table->text('sgpt')->nullable();
            $table->text('sgot')->nullable();
            $table->text('ggt')->nullable();
            $table->text('ast')->nullable();
            $table->text('s_albumin')->nullable();
            $table->text('s_lipase')->nullable();
            $table->text('s_amylase')->nullable();
            $table->text('blood_glucose')->nullable();
            $table->text('x_ray')->nullable();
            $table->text('ecg')->nullable();
            $table->text('usg')->nullable();
            $table->text('ct_scan')->nullable();
            $table->text('mri')->nullable();
            $table->text('mrcp')->nullable();
            $table->text('ercp')->nullable();
            $table->text('endoscopy')->nullable();
            $table->text('colonoscopy')->nullable();
            $table->text('fnac')->nullable();
            $table->text('histopathology')->nullable();
            $table->text('immuno_histochemistry')->nullable();
            $table->text('genetic_analysis')->nullable();
            $table->text('others')->nullable();
            $table->text('name_of_surgeon')->nullable();
            $table->text('name_of_surgeon_assistant')->nullable();
            $table->text('name_of_operation')->nullable();
            $table->date('date_of_operation')->nullable(); // Made nullable
            $table->text('name_of_anesthesia')->nullable();
            $table->text('operative_findings')->nullable();
            $table->date('date_of_death')->nullable(); // Made nullable
            $table->text('causes_death')->nullable();

            $table->string('created_ip', 15)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip', 15)->nullable();

            $table->timestamps();

            // Optional: Add foreign key constraints if applicable
            // $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict');
            // $table->foreign('occupation')->references('id')->on('occupations')->onDelete('restrict');
            // $table->foreign('education_status')->references('id')->on('education_statuses')->onDelete('restrict');
            // $table->foreign('diagnosis')->references('id')->on('diagnoses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_info');
    }
};

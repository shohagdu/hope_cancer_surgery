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
        Schema::create('patient_medicine_dosage', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('patient_medicine_id'); // FK to patient_medicine table
            $table->string('dosage_morning')->nullable();
            $table->string('dosage_noon')->nullable();
            $table->string('dosage_afternoon')->nullable();
            $table->string('dosage_night')->nullable();
            $table->string('drug_taking_quantity_unit')->nullable(); // চামচ,ফোঁটা,মিলি,পাফস,ইউনিট
            $table->string('meal_time_select')->nullable(); // খাবারের পরে,খাবারের আগে,ঘুমানোর আগে,N/A
            $table->integer('duration')->nullable();
            $table->string('duration_unit_check')->nullable(); // দিন, চলবে, N/A
            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 2 = Inactive, 0 = Delete');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->ipAddress('created_ip')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->ipAddress('updated_ip')->nullable();
            $table->timestamps(); // created_at & updated_at

            // Optional: index for foreign key
            $table->index('patient_medicine_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medicine_dosage');
    }
};

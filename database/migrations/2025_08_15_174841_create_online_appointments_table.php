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
        Schema::create('online_appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time'); // Appointment date & time
            $table->unsignedBigInteger('doctor_id'); // Foreign key to doctors table
            $table->string('patient_name');
            $table->string('mobile', 20);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->tinyInteger('patient_type')->comment('1 = New, 2 = Old');

            $table->string('age', 50);
            $table->integer('district_id')->nullable();
            $table->integer('upazila_id')->nullable();
            $table->integer('union_id')->nullable();
            $table->string('referer_doctor')->nullable();
            $table->string('remarks')->nullable();

            $table->integer('created_by')->nullable();
            $table->string('created_ip',15)->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip',15)->nullable();
            $table->timestamps();

            // Optional: Add foreign key if you have a doctors table
            // $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_appointments');
    }
};

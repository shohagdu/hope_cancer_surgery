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
        Schema::create('patient_medicine', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->bigInteger('patient_id')->unsigned()->nullable();
            $table->string('medicine_id');
            $table->text('custom_time_instruction')->nullable();
            $table->string('medicine_serial')->nullable();
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
        Schema::dropIfExists('patient_medicine');
    }
};

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
        Schema::create('patient_follow_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            $table->text('clinical_features')->nullable();
            $table->text('investigation')->nullable();
            $table->text('followup_description')->nullable();
            $table->string('created_ip', 15)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip', 15)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_follow_histories');
    }
};

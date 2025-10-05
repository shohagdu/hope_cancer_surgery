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
        Schema::create('doctor_chambers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('chamber_name');
            $table->string('available_days')->nullable(); // e.g., "Mon, Tue, Wed"
            $table->time('opening_time')->nullable();
            $table->time('report_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->decimal('fee_first_time', 10, 2)->nullable();
            $table->decimal('fee_followup', 10, 2)->nullable();
            $table->text('address')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_chambers');
    }
};

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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Doctor's Name
            $table->string('picture')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('special_training')->nullable();
            $table->string('positions')->nullable(); // Designation / Position
            $table->text('doctor_profile')->nullable();
            $table->string('mobile',30)->nullable(); // Designation / Position
            $table->string('email',150)->nullable(); // Designation / Position
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->integer('display_position')->nullable()->default(0); // For sorting display order
            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->integer('created_by')->nullable();
            $table->string('created_ip',15)->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip',15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

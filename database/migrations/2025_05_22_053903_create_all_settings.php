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
        Schema::create('all_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('type')->nullable();
            $table->integer('display_order')->nullable();
            $table->string('is_active')->comment('1=Active, 2=Inactive, 3=Delete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_settings');
    }
};

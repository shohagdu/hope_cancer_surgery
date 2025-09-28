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
        Schema::create('prescrip_drug_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 2 = Inactive, 0 = Delete');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescrip_drug_manufacturers');
    }
};

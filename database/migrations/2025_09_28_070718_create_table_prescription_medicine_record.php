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
        Schema::create('prescription_medicine_record', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->constrained('prescrip_drug_manufacturers')->onDelete('cascade');
            $table->foreignId('dosage_id')->constrained('prescrip_drug_type')->onDelete('cascade');

            // Medicine info
            $table->string('name', 255);
            $table->string('generic', 800)->nullable();;
            $table->string('strength', 800)->nullable();

            // Price + Use For + DAR
            $table->decimal('price', 10, 2)->default(0);
            $table->string('use_for', 100)->nullable();  // e.g. Human, Veterinary
            $table->string('DAR', 100)->nullable();      // Drug Administration Registration
            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 2 = Inactive, 0 = Delete');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medicine_record');
    }
};

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
        Schema::create('prescrip_sidebar_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('added_by')->comment('1=superadmin, 2=Doctor');
            $table->enum('type', [
                'complaints',
                'on_examination',
                'pastHistory',
                'drugHistory',
                'investigation',
                'diagnosis',
                'treatmentPlan',
                'operationNote',
                'advice',
                'nextPlan',
                'hospitalizations'
            ]);
            $table->string('title')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('1 = Active, 2 = Inactive, 0 = Delete');
            $table->tinyInteger('is_show')->default(1)->comment('1=show,2=waiting for approval');
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
        Schema::dropIfExists('prescrip_sidebar_settings');
    }
};

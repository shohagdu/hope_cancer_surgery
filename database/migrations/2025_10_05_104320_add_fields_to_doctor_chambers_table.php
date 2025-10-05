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
        Schema::table('doctor_chambers', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->nullable()->after('id'); // new doctor reference
            $table->tinyInteger('is_active')->default(1)->after('address')->comment('1=active, 0=inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_chambers', function (Blueprint $table) {
            //
        });
    }
};

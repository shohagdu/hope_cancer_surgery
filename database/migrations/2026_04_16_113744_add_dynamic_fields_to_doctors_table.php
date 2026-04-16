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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('hero_tag')->nullable()->after('positions');
            $table->string('stat_experience')->nullable()->after('hero_tag');
            $table->string('stat_publications')->nullable()->after('stat_experience');
            $table->string('stat_patients')->nullable()->after('stat_publications');
            $table->string('stat_success_rate')->nullable()->after('stat_patients');
            $table->json('expertise')->nullable()->after('stat_success_rate');
            $table->json('chambers')->nullable()->after('expertise');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['hero_tag','stat_experience','stat_publications',
                'stat_patients','stat_success_rate','expertise','chambers']);
        });
    }
};

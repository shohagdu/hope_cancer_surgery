<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->json('testimonials')->nullable()->after('google_map_link');
            $table->string('testimonials_heading', 255)->nullable()->after('testimonials');
            $table->text('testimonials_subtext')->nullable()->after('testimonials_heading');
        });
    }

    public function down(): void
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->dropColumn(['testimonials', 'testimonials_heading', 'testimonials_subtext']);
        });
    }
};

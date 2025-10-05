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
//            $table->json('print_settings')->nullable()->after('youtube');
//            $table->json('sidebar_titles')->nullable(); //{[“PatientComplaints”:”Patient Complaints”,”is_active”:”YES”],[“OnExamination”:”On Examination”,”is_active”:”YES”]}
//
//            $table->json('prescription_header_options')->nullable(); // {‘text’:’Yes’,’image’:’No’,’empty’:’No’}
//            $table->json('prescription_header_text')->nullable(); //{“Bangla”:{”Name”:”test”,”line1”:”test”,”line2”:”test”,”line3”:”test”,,”line4”:”test”},{”English”:{”Name”:”test”,”line1”:”test”,”line2”:”test”,”line3”:”test”,,”line4”:”test”}}
//            $table->string('prescription_header_image')->nullable(); // Store path or URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};

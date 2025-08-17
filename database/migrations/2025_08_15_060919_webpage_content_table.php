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
        Schema::create('webpage_contents', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->tinyInteger('type')->unsigned()->comment('1=Why Choose, 2=About Us, 3=Service (Treatment), 4=Emergency Service (Treatment), 5=FAQ, 6=Testimonial, 7=Picture, 8=Video');
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('storage_type')->nullable()->comment('Used for type 7 or 8');
            $table->string('file_path')->nullable()->comment('Used for type 7 or 8');
            $table->integer('display_position')->unsigned()->default(0);
            $table->tinyInteger('is_highlight_item')->unsigned()->default(0)->comment('1=Yes, 2=No');
            $table->tinyInteger('is_active')->unsigned()->default(1)->comment('1=Active, 2=Inactive, 3=Deleted');
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
        Schema::dropIfExists('webpage_contents');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('online_appointments', 'message')) {
                $table->text('message')->nullable()->after('remarks');
            }
            if (!Schema::hasColumn('online_appointments', 'status')) {
                $table->tinyInteger('status')->default(1)->comment('1=Pending, 2=Confirmed, 3=Cancelled')->after('message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('online_appointments', function (Blueprint $table) {
            $table->dropColumn(['message', 'status']);
        });
    }
};

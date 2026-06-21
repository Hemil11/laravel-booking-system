<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            if (! Schema::hasColumn('staffs', 'start_time')) {
                $table->time('start_time')->default('09:00:00')->after('bio');
            }
            if (! Schema::hasColumn('staffs', 'end_time')) {
                $table->time('end_time')->default('17:00:00')->after('start_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            if (Schema::hasColumn('staffs', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('staffs', 'start_time')) {
                $table->dropColumn('start_time');
            }
        });
    }
};

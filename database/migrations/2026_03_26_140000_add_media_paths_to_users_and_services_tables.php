<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path', 500)->nullable()->after('password');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('image_path', 500)->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_path');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('staff_id')->constrained('staffs')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->time('time');
            $table->string('status', 30)->default('pending');
            $table->dateTime('cancelled_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['staff_id', 'date']);
            $table->index(['user_id', 'date']);
            $table->index(['service_id', 'date']);
            $table->index(['status', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};


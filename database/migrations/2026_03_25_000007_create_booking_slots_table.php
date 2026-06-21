<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('staff_id')->constrained('staffs')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->time('time');
            $table->timestamps();

            $table->unique(['staff_id', 'date', 'time']);
            $table->index(['staff_id', 'date']);
            $table->index(['booking_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_slots');
    }
};


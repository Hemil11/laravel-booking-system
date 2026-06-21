<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete()->cascadeOnUpdate();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('price_override_cents')->nullable();
            $table->char('currency', 3)->nullable();
            $table->timestamps();

            $table->unique(['staff_id', 'service_id']);
            $table->index(['service_id']);
            $table->index(['staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_service');
    }
};


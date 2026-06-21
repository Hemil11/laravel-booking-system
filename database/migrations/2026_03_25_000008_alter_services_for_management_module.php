<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        // Fresh installs may already have `duration` + `price` from create_services_table.
        if (Schema::hasColumn('services', 'duration') && Schema::hasColumn('services', 'price')) {
            return;
        }

        if (Schema::hasColumn('services', 'duration_minutes') && ! Schema::hasColumn('services', 'duration')) {
            Schema::table('services', function (Blueprint $table) {
                $table->renameColumn('duration_minutes', 'duration');
            });
        }

        if (! Schema::hasColumn('services', 'price')) {
            Schema::table('services', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->default(0)->after('duration');
            });
        }

        if (Schema::hasColumn('services', 'base_price_cents')) {
            foreach (DB::table('services')->get() as $row) {
                $cents = $row->base_price_cents;
                DB::table('services')->where('id', $row->id)->update([
                    'price' => $cents !== null ? round(((int) $cents) / 100, 2) : 0,
                ]);
            }

            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn(['base_price_cents', 'currency']);
            });
        }

        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('services', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            if (! Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable();
            }
            if (! Schema::hasColumn('services', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (! Schema::hasColumn('services', 'base_price_cents')) {
                $table->unsignedInteger('base_price_cents')->nullable();
            }
            if (! Schema::hasColumn('services', 'currency')) {
                $table->char('currency', 3)->nullable();
            }
        });

        if (Schema::hasColumn('services', 'price')) {
            foreach (DB::table('services')->get() as $row) {
                DB::table('services')->where('id', $row->id)->update([
                    'base_price_cents' => (int) round(((float) $row->price) * 100),
                ]);
            }

            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }

        if (Schema::hasColumn('services', 'duration') && ! Schema::hasColumn('services', 'duration_minutes')) {
            Schema::table('services', function (Blueprint $table) {
                $table->renameColumn('duration', 'duration_minutes');
            });
        }
    }
};

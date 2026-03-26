<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Role;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'staff'], ['guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer'], ['guard_name' => 'web']);

        // Services
        $services = Service::factory()->count(10)->create();

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->roles()->sync([$adminRole->id]);

        // Staff
        $staffUsers = User::factory()->count(6)->create();
        $staffs = $staffUsers->map(function (User $user) use ($staffRole) {
            $staff = Staff::factory()->create([
                'user_id' => $user->id,
                'full_name' => $user->name,
            ]);
            $user->roles()->sync([$staffRole->id]);

            return $staff;
        });

        // Staff <-> Services pivot
        $staffs->each(function (Staff $staff) use ($services) {
            $offered = $services->random(rand(3, 6));

            foreach ($offered as $service) {
                $staff->services()->attach($service->id, [
                    'is_active' => true,
                    'price_override_cents' => fake()->boolean(70) ? null : fake()->numberBetween(2000, 10000),
                    'currency' => 'USD',
                ]);
            }
        });

        // Customers
        $customers = User::factory()->count(30)->create();
        $customers->each(function (User $user) use ($customerRole) {
            $user->roles()->sync([$customerRole->id]);
        });

        // Create bookings aligned to a 30-minute grid with no overlaps per staff.
        $baseDate = Carbon::now();
        foreach ($staffs as $staff) {
            $date = $baseDate->copy()->addDays(rand(1, 14))->toDateString();
            $current = Carbon::createFromTime(9, 0);
            $end = Carbon::createFromTime(17, 0);

            $offeredServices = $staff->services()->get();
            if ($offeredServices->isEmpty()) {
                continue;
            }

            $bookingsToCreate = 5;
            for ($i = 0; $i < $bookingsToCreate; $i++) {
                $service = $offeredServices->random();
                $duration = (int) $service->duration;

                if ($current->copy()->addMinutes($duration)->greaterThan($end)) {
                    break;
                }

                $customer = $customers->random();

                Booking::factory()->create([
                    'user_id' => $customer->id,
                    'staff_id' => $staff->id,
                    'service_id' => $service->id,
                    'date' => $date,
                    'time' => $current->format('H:i:s'),
                    'status' => 'confirmed',
                ]);

                $current->addMinutes($duration);
            }
        }
    }
}


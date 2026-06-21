<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $permissionNames = [
            'manage_users',
            'manage_bookings',
            'manage_services',
            'manage_staff',
        ];

        $permissions = collect($permissionNames)->mapWithKeys(function (string $name) {
            return [
                $name => Permission::firstOrCreate(
                    ['name' => $name],
                    ['guard_name' => 'web']
                ),
            ];
        });

        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'staff'], ['guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer'], ['guard_name' => 'web']);

        $adminRole->permissions()->sync($permissions->pluck('id')->all());
        $staffRole->permissions()->sync([
            $permissions['manage_bookings']->id,
        ]);
        $customerRole->permissions()->sync([]);

        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
        ]);

        $services = Service::query()->orderBy('id')->get();

        $primaryStaff = Staff::query()
            ->whereRelation('user', 'email', 'staff@admin.com')
            ->firstOrFail();

        $offered = $services->count() >= 6
            ? $services->random(6)
            : $services;
        $primaryPivot = [];
        foreach ($offered as $service) {
            $primaryPivot[$service->id] = [
                'is_active' => true,
                'price_override_cents' => null,
                'currency' => 'USD',
            ];
        }
        $primaryStaff->services()->sync($primaryPivot);

        $staffUsers = User::factory()->count(5)->create();
        $staffs = $staffUsers->map(function (User $user) use ($staffRole) {
            $staff = Staff::factory()->create([
                'user_id' => $user->id,
                'full_name' => $user->name,
            ]);
            $user->roles()->sync([$staffRole->id]);

            return $staff;
        });

        $allStaffForBookings = $staffs->push($primaryStaff);

        $allStaffForBookings->each(function (Staff $staff) use ($services, $primaryStaff) {
            if ($staff->is($primaryStaff)) {
                return;
            }

            $count = min(6, max(3, $services->count()));
            $offered = $services->random(min($count, $services->count()));
            $pivot = [];
            foreach ($offered as $service) {
                $pivot[$service->id] = [
                    'is_active' => true,
                    'price_override_cents' => fake()->boolean(70) ? null : fake()->numberBetween(2000, 10000),
                    'currency' => 'USD',
                ];
            }
            $staff->services()->sync($pivot);
        });

        $customers = User::factory()->count(25)->create();
        $customers->each(function (User $user) use ($customerRole) {
            $user->roles()->sync([$customerRole->id]);
        });

        $demoCustomer = User::query()->where('email', 'demo@admin.com')->firstOrFail();
        $customers = $customers->push($demoCustomer);

        $baseDate = Carbon::now();
        foreach ($allStaffForBookings as $staff) {
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

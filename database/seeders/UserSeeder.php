<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed fixed accounts for local/demo use.
     * Passwords are hashed via the User model's "hashed" cast when assigned.
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();
        $staffRole = Role::query()->where('name', 'staff')->firstOrFail();
        $customerRole = Role::query()->where('name', 'customer')->firstOrFail();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );
        $admin->roles()->sync([$adminRole->id]);

        $staffUser = User::query()->updateOrCreate(
            ['email' => 'staff@admin.com'],
            [
                'name' => 'Staff Member',
                'password' => 'password',
            ]
        );
        $staffUser->roles()->sync([$staffRole->id]);

        Staff::query()->updateOrCreate(
            ['user_id' => $staffUser->id],
            [
                'full_name' => $staffUser->name,
                'phone' => '+1 555 0100',
                'bio' => 'Experienced technician available for on-site bookings.',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'is_active' => true,
            ]
        );

        $customer = User::query()->updateOrCreate(
            ['email' => 'demo@admin.com'],
            [
                'name' => 'Demo Customer',
                'password' => 'password',
            ]
        );
        $customer->roles()->sync([$customerRole->id]);
    }
}

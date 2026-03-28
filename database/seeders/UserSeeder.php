<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Demo accounts for local/staging. Password for all: "password".
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();
        $staffRole = Role::query()->where('name', 'staff')->firstOrFail();
        $customerRole = Role::query()->where('name', 'customer')->firstOrFail();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Jordan Hale',
                'password' => 'password',
            ]
        );
        $admin->forceFill(['email_verified_at' => now()])->save();
        $admin->roles()->sync([$adminRole->id]);

        $staffUser = User::query()->updateOrCreate(
            ['email' => 'staff@admin.com'],
            [
                'name' => 'Sam Rivera',
                'password' => 'password',
            ]
        );
        $staffUser->forceFill(['email_verified_at' => now()])->save();
        $staffUser->roles()->sync([$staffRole->id]);

        Staff::query()->updateOrCreate(
            ['user_id' => $staffUser->id],
            [
                'full_name' => 'Sam Rivera',
                'phone' => '+1 (555) 014-2200',
                'bio' => 'Licensed HVAC and general maintenance technician with 8+ years on residential and light commercial jobs. Punctual, tidy, and happy to explain options before any work begins.',
                'start_time' => '08:30:00',
                'end_time' => '17:30:00',
                'is_active' => true,
            ]
        );

        $customer = User::query()->updateOrCreate(
            ['email' => 'demo@admin.com'],
            [
                'name' => 'Morgan Lee',
                'password' => 'password',
            ]
        );
        $customer->forceFill(['email_verified_at' => now()])->save();
        $customer->roles()->sync([$customerRole->id]);
    }
}

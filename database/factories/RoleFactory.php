<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $names = ['admin', 'staff', 'customer'];

        return [
            'name' => $this->faker->randomElement($names),
            'guard_name' => 'web',
        ];
    }
}


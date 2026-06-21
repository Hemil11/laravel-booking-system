<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'user_id' => null,
            'full_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'bio' => $this->faker->paragraph(2),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ];
    }
}


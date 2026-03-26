<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $duration = $this->faker->randomElement([30, 60, 90, 120]);

        return [
            // `services.name` is UNIQUE in MySQL, so include a UUID suffix to avoid collisions across multiple seeder runs.
            'name' => $this->faker->words(3, true) . ' ' . Str::uuid(),
            'duration' => $duration,
            'price' => $this->faker->randomFloat(2, 15, 800),
        ];
    }
}


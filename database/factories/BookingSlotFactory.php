<?php

namespace Database\Factories;

use App\Models\BookingSlot;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingSlot>
 */
class BookingSlotFactory extends Factory
{
    protected $model = BookingSlot::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'staff_id' => Staff::factory(),
            'service_id' => Service::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'time' => $this->faker->randomElement(['09:00:00', '09:30:00', '10:00:00', '10:30:00']),
        ];
    }
}


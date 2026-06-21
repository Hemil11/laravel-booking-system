<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $hour = $this->faker->numberBetween(9, 16);
        $minute = $this->faker->randomElement([0, 30]);

        return [
            'user_id' => User::factory(),
            'staff_id' => Staff::factory(),
            'service_id' => Service::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+14 days')->format('Y-m-d'),
            'time' => sprintf('%02d:%02d:00', $hour, $minute),
            'status' => 'confirmed',
            'cancelled_at' => null,
            'notes' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Booking $booking): void {
            // Cancelled bookings should not occupy slots.
            if (in_array($booking->status, ['cancelled', 'completed'], true)) {
                return;
            }

            $booking->loadMissing('service');

            $duration = (int) ($booking->service?->duration ?? 30);
            $slotCount = $duration > 0 ? intdiv($duration, 30) : 1;

            $date = $booking->date instanceof Carbon
                ? $booking->date->toDateString()
                : (string) $booking->date;

            $startTime = Carbon::createFromFormat('H:i:s', $booking->time);

            for ($i = 0; $i < $slotCount; $i++) {
                BookingSlot::create([
                    'booking_id' => $booking->id,
                    'staff_id' => $booking->staff_id,
                    'service_id' => $booking->service_id,
                    'date' => $date,
                    'time' => $startTime->copy()->addMinutes(30 * $i)->format('H:i:s'),
                ]);
            }
        });
    }
}

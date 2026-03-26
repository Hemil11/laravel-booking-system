<?php

namespace App\Services\Booking;

use App\Exceptions\BookingConflictException;
use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BookingService
{
    /**
     * Internal grid step (minutes). Service duration must be a multiple of this value.
     */
    public const SLOT_STEP_MINUTES = 30;

    /**
     * Return candidate start times (H:i:s) that fit staff hours, service duration, and existing bookings.
     *
     * @return list<array{start: string, label: string}>
     */
    public function getAvailableSlots(Staff $staff, Service $service, Carbon|string $date, bool $excludePastSameDay = true): array
    {
        $this->assertStaffOffersService($staff, $service);
        $this->assertDurationAligned($service);

        $day = Carbon::parse($date)->startOfDay();
        if (! $staff->is_active) {
            return [];
        }

        $duration = (int) $service->duration;
        $slotCount = intdiv($duration, self::SLOT_STEP_MINUTES);

        $dayStart = $day->copy()->setTimeFromTimeString($this->normalizeTimeString($staff->start_time));
        $dayEnd = $day->copy()->setTimeFromTimeString($this->normalizeTimeString($staff->end_time));

        if ($dayEnd->lte($dayStart)) {
            return [];
        }

        $occupied = $this->occupiedSlotTimes($staff->id, $day->toDateString());
        $occupiedSet = array_fill_keys($occupied, true);

        $now = Carbon::now();

        $out = [];
        $cursor = $dayStart->copy();

        while ($cursor->copy()->addMinutes($duration)->lte($dayEnd)) {
            $start = $cursor->copy();
            $blocked = false;

            for ($i = 0; $i < $slotCount; $i++) {
                $chunk = $start->copy()->addMinutes(self::SLOT_STEP_MINUTES * $i);
                $key = $chunk->format('H:i:s');
                if (isset($occupiedSet[$key])) {
                    $blocked = true;
                    break;
                }
            }

            if (! $blocked && $excludePastSameDay && $day->isSameDay($now)) {
                if ($start->lt($now)) {
                    $blocked = true;
                }
            }

            if (! $blocked) {
                $out[] = [
                    'start' => $start->format('H:i:s'),
                    'label' => $start->format('g:i A'),
                ];
            }

            $cursor->addMinutes(self::SLOT_STEP_MINUTES);
        }

        return $out;
    }

    /**
     * Create a booking and reserve underlying 30-minute slots.
     *
     * @param  'pending'|'confirmed'  $status
     */
    public function createBooking(
        User $user,
        Staff $staff,
        Service $service,
        string $date,
        string $time,
        string $status = 'pending',
        ?string $notes = null,
    ): Booking {
        if (! in_array($status, ['pending', 'confirmed'], true)) {
            throw new InvalidArgumentException('New bookings may only be created as pending or confirmed.');
        }

        $this->assertStaffOffersService($staff, $service);
        $this->assertDurationAligned($service);

        $day = Carbon::parse($date)->startOfDay();
        $start = $day->copy()->setTimeFromTimeString($this->normalizeTimeString($time));
        $duration = (int) $service->duration;
        $slotCount = intdiv($duration, self::SLOT_STEP_MINUTES);

        $this->assertNotInPast($day, $start);
        $this->assertWithinWorkingHours($staff, $start, $duration);
        $this->assertSlotsFree($staff->id, $day->toDateString(), $start, $slotCount);

        try {
            return DB::transaction(function () use ($user, $staff, $service, $day, $start, $status, $notes, $slotCount) {
                $booking = Booking::query()->create([
                    'user_id' => $user->id,
                    'staff_id' => $staff->id,
                    'service_id' => $service->id,
                    'date' => $day->toDateString(),
                    'time' => $start->format('H:i:s'),
                    'status' => $status,
                    'cancelled_at' => null,
                    'notes' => $notes,
                ]);

                for ($i = 0; $i < $slotCount; $i++) {
                    $chunk = $start->copy()->addMinutes(self::SLOT_STEP_MINUTES * $i);
                    BookingSlot::query()->create([
                        'booking_id' => $booking->id,
                        'staff_id' => $staff->id,
                        'service_id' => $service->id,
                        'date' => $day->toDateString(),
                        'time' => $chunk->format('H:i:s'),
                    ]);
                }

                return $booking->fresh(['staff', 'service', 'user']);
            });
        } catch (QueryException $e) {
            if ($this->isUniqueConstraintViolation($e)) {
                throw new BookingConflictException(__('That time slot is no longer available.'), 0, $e);
            }
            throw $e;
        }
    }

    public function confirmBooking(Booking $booking): Booking
    {
        if ($booking->status === 'cancelled') {
            throw new InvalidArgumentException(__('Cannot confirm a cancelled booking.'));
        }

        if ($booking->status === 'confirmed') {
            return $booking;
        }

        $booking->update(['status' => 'confirmed']);

        return $booking->fresh();
    }

    public function cancelBooking(Booking $booking): Booking
    {
        if ($booking->status === 'cancelled') {
            return $booking;
        }

        return DB::transaction(function () use ($booking) {
            $booking->slots()->delete();
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return $booking->fresh();
        });
    }

    /**
     * @return list<string> Times as H:i:s
     */
    protected function occupiedSlotTimes(int $staffId, string $dateYmd): array
    {
        return BookingSlot::query()
            ->where('staff_id', $staffId)
            ->whereDate('date', $dateYmd)
            ->pluck('time')
            ->map(fn ($t) => $this->normalizeTimeString((string) $t))
            ->values()
            ->all();
    }

    protected function assertStaffOffersService(Staff $staff, Service $service): void
    {
        $exists = $staff->services()
            ->where('services.id', $service->id)
            ->wherePivot('is_active', true)
            ->exists();

        if (! $exists) {
            throw new InvalidArgumentException(__('This staff member does not offer the selected service.'));
        }
    }

    protected function assertDurationAligned(Service $service): void
    {
        $duration = (int) $service->duration;
        if ($duration <= 0 || $duration % self::SLOT_STEP_MINUTES !== 0) {
            throw new InvalidArgumentException(
                __('Service duration must be a positive multiple of :step minutes.', ['step' => self::SLOT_STEP_MINUTES])
            );
        }
    }

    protected function assertNotInPast(Carbon $day, Carbon $start): void
    {
        $now = Carbon::now();
        if ($day->copy()->startOfDay()->lt($now->copy()->startOfDay())) {
            throw new InvalidArgumentException(__('Cannot book a date in the past.'));
        }

        if ($day->isSameDay($now) && $start->lt($now)) {
            throw new InvalidArgumentException(__('Cannot book a time in the past.'));
        }
    }

    protected function assertWithinWorkingHours(Staff $staff, Carbon $start, int $durationMinutes): void
    {
        $day = $start->copy()->startOfDay();
        $dayStart = $day->copy()->setTimeFromTimeString($this->normalizeTimeString($staff->start_time));
        $dayEnd = $day->copy()->setTimeFromTimeString($this->normalizeTimeString($staff->end_time));

        if ($start->lt($dayStart) || $start->copy()->addMinutes($durationMinutes)->gt($dayEnd)) {
            throw new InvalidArgumentException(__('The selected time is outside working hours.'));
        }
    }

    /**
     * @param  int  $slotCount  Number of :SLOT_STEP_MINUTES blocks
     */
    protected function assertSlotsFree(int $staffId, string $dateYmd, Carbon $start, int $slotCount): void
    {
        $occupied = array_fill_keys($this->occupiedSlotTimes($staffId, $dateYmd), true);

        for ($i = 0; $i < $slotCount; $i++) {
            $chunk = $start->copy()->addMinutes(self::SLOT_STEP_MINUTES * $i);
            $key = $chunk->format('H:i:s');
            if (isset($occupied[$key])) {
                throw new BookingConflictException(__('That time slot is already booked.'));
            }
        }
    }

    protected function normalizeTimeString(string $time): string
    {
        $time = trim($time);
        if (strlen($time) === 5) {
            return $time . ':00';
        }

        return $time;
    }

    protected function isUniqueConstraintViolation(QueryException $e): bool
    {
        $msg = $e->getMessage();

        return str_contains($msg, 'Duplicate entry')
            || str_contains($msg, 'UNIQUE constraint')
            || str_contains($msg, 'duplicate key');
    }
}

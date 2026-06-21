<?php

namespace App\Models;

use App\Support\PerformanceCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted(): void
    {
        $flush = function (): void {
            cache()->forget(PerformanceCache::BOOKING_FORM_STAFF);
        };

        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
        static::forceDeleted($flush);
    }

    // "staff" is uncountable in English; Laravel's default pluralization may resolve to `staff`.
    // Your migration uses `staffs`, so pin the table name explicitly.
    protected $table = 'staffs';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'bio',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'staff_service')
            ->using(StaffService::class)
            ->withPivot(['is_active', 'price_override_cents', 'currency'])
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(BookingSlot::class, 'staff_id');
    }
}

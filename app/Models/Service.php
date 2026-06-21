<?php

namespace App\Models;

use App\Support\PerformanceCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted(): void
    {
        $flushLists = function (): void {
            cache()->forget(PerformanceCache::API_SERVICES_INDEX);
            PerformanceCache::forgetBookingDropdowns();
        };

        static::saved($flushLists);
        static::deleted($flushLists);
        static::restored($flushLists);
        static::forceDeleted($flushLists);
    }

    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'image_path',
    ];

    protected $casts = [
        'duration' => 'integer',
        'price' => 'decimal:2',
    ];

    public function staffs(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'staff_service')
            ->using(StaffService::class)
            ->withPivot(['is_active', 'price_override_cents', 'currency'])
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

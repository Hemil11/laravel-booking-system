<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'staff_id',
        'service_id',
        'date',
        'time',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    public const STATUS_UNPAID = 'unpaid';

    public const STATUS_PAID = 'paid';

    protected $fillable = [
        'booking_id',
        'amount',
        'tax',
        'total',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

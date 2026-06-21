<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StaffService extends Pivot
{
    protected $table = 'staff_service';

    protected $fillable = [
        'staff_id',
        'service_id',
        'is_active',
        'price_override_cents',
        'currency',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}


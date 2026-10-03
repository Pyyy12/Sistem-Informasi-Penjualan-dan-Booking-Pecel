<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'table_id',
        'customer_name',
        'customer_whatsapp',
        'booking_date',
        'booking_time',
        'package_name',
        'total_price',
        'payment_method',
        'status',
        'notes',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
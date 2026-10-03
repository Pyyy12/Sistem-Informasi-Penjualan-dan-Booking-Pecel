<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $fillable = [
        'sale_date',
        'total_portions_sold',
        'dine_in_revenue',
        'booking_revenue',
        'total_revenue',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];
}
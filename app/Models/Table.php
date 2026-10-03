<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    protected $fillable = ['table_number', 'category', 'capacity', 'min_order_price', 'is_active'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
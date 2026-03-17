<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'name', 'description', 'price', 'capacity', 'image'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

        public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAvailable($checkIn, $checkOut)
    {
        return !$this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->exists();
    }
}

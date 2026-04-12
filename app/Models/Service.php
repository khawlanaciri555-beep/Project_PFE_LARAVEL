<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'image',
        'description',
        'availability',
        'is_deleted',
        'cooperative_id',
        'place_id',
        'hotel_id',
        'transport_id',
        'price',
        'rating',
    ];

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

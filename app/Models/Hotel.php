<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'phone',
        'email',
        'address',
        'image',
        'price',
        'description',
        'user_id',
        'place_id',
        'image',
        'availability',
        'is_deleted',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

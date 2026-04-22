<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    /** @use HasFactory<\Database\Factories\TransportFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'price',
        'availability',
        'description',
        'user_id',
        'place_id',
        'image',
        'license_doc',
        'phone',
        'is_deleted',
        'gallery',
    ];

    protected $casts = [
        'gallery' => 'array',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperative extends Model
{
    /** @use HasFactory<\Database\Factories\CooperativeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'image',
        'description',
        'user_id',
        'place_id',
        'image',
        'certificate',
        'availability',
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

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
        'phone',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    /** @use HasFactory<\Database\Factories\EmergencyFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

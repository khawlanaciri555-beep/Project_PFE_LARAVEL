<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'place_id',
        'cooperative_id',
        'transport_id',
        'hotel_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

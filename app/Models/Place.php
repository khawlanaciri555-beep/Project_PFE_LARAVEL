<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /** @use HasFactory<\Database\Factories\PlaceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'image',
        'description',
        'category',
        'coordinates',
        'is_deleted',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function planningItems()
    {
        return $this->hasMany(PlanningItem::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function getTotalVotesAttribute()
    {
        return $this->ratings()->count();
    }
}

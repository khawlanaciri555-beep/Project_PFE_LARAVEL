<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    /** @use HasFactory<\Database\Factories\GuideFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'language',
        'experience',
        'price',
        'image',
        'description',
        'user_id',
        'status',
        'is_deleted',
    ];

    /**
     * Get the user that owns the guide.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services for the guide.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

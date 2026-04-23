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

    public function getGalleryAttribute()
    {
        if (!$this->image) return [];
        
        // If the image is stored in storage/Activiti/...
        // We can find other images in the same folder
        $path = public_path($this->image);
        if (file_exists($path)) {
            $directory = dirname($path);
            if (str_contains($directory, 'Activiti')) {
                $files = glob($directory . '/*.{jpg,jpeg,png,webp,PNG}', GLOB_BRACE);
                return array_map(function($file) {
                    // Convert absolute path back to public path
                    return str_replace(public_path(), '', $file);
                }, $files);
            }
        }
        
        return [$this->image];
    }
}

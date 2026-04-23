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
        
        // Build absolute path, normalize slashes for Windows compatibility
        $imagePath = ltrim(str_replace('\\', '/', $this->image), '/');
        $absPath = public_path() . '/' . $imagePath;
        $absPath = str_replace('\\', '/', $absPath);

        if (!file_exists($absPath)) {
            return [$this->image];
        }

        $directory = dirname($absPath);
        
        if (str_contains($directory, 'Activiti')) {
            $files = glob($directory . '/*.{jpg,jpeg,png,webp,PNG}', GLOB_BRACE);
            if (empty($files)) {
                return [$this->image];
            }
            return array_values(array_map(function($file) {
                // Normalize to forward slashes and make relative to public/
                $file = str_replace('\\', '/', $file);
                $publicPath = str_replace('\\', '/', public_path());
                $relative = str_replace($publicPath, '', $file);
                // Ensure single leading slash
                return '/' . ltrim($relative, '/');
            }, $files));
        }
        
        return [$this->image];
    }
}

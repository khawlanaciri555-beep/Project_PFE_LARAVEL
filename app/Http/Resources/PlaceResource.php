<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        $placeName = $this->name;
        $directory = 'places/' . $placeName;

        // Try direct match
        $targetDir = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($directory)) {
            $targetDir = $directory;
        } else {
            // Flexible match: lists subdirectories under 'places'
            $folders = \Illuminate\Support\Facades\Storage::disk('public')->directories('places');
            $placeWords = explode(' ', mb_strtolower($placeName));
            $firstWord = $placeWords[0] ?? '';

            foreach ($folders as $folder) {
                $folderName = mb_strtolower(basename($folder));
                $placeLower = mb_strtolower($placeName);
                
                // match if one contains the other, or if they share the same starting characters of the first word
                if (mb_stripos($placeLower, $folderName) !== false || 
                    mb_stripos($folderName, $placeLower) !== false ||
                    (mb_strlen($firstWord) > 4 && mb_stripos($folderName, mb_substr($firstWord, 0, 5)) !== false)) {
                    $targetDir = $folder;
                    break;
                }
            }
        }

        $images = [];

        // Add images from the database gallery if present
        if ($this->gallery && is_array($this->gallery)) {
            foreach ($this->gallery as $path) {
                // Ensure path starts with /storage/
                $cleanPath = str_starts_with($path, '/') ? $path : '/' . $path;
                $cleanPath = str_starts_with($cleanPath, '/storage') ? $cleanPath : '/storage/' . ltrim($cleanPath, '/');
                $images[] = $cleanPath;
            }
        }

        if ($targetDir) {
            $files = \Illuminate\Support\Facades\Storage::disk('public')->files($targetDir);
            foreach ($files as $file) {
                // Ensure we only take image files
                if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                    $images[] = '/storage/' . $file;
                }
            }
        }

        // Fallback to default image if no local images found
        if (empty($images) && $this->image) {
            if (str_starts_with($this->image, 'http')) {
                $images[] = $this->image;
            } else {
                $cleanPath = str_starts_with($this->image, '/') ? $this->image : '/' . $this->image;
                $cleanPath = str_starts_with($cleanPath, '/storage') ? $cleanPath : '/storage/' . ltrim($cleanPath, '/');
                $images[] = $cleanPath;
            }
        }

        // 1. Process Standalone Services (not linked to any provider)
        $standaloneServices = \App\Models\Service::where('place_id', $this->id)
            ->whereNull('hotel_id')
            ->whereNull('transport_id')
            ->whereNull('cooperative_id')
            ->get();

        $groupedServices = [
            'guides' => [],
            'hotels' => [],
            'activites' => [],
            'restaurants' => [],
            'transport' => []
        ];

        foreach ($standaloneServices as $s) {
            $cleanServiceImage = $s->image;
            if ($cleanServiceImage && !str_starts_with($cleanServiceImage, 'http')) {
                $cleanServiceImage = str_starts_with($cleanServiceImage, '/') ? $cleanServiceImage : '/' . $cleanServiceImage;
                $cleanServiceImage = str_starts_with($cleanServiceImage, '/storage') ? $cleanServiceImage : '/storage/' . ltrim($cleanServiceImage, '/');
            }

            $item = [
                'id' => $s->id,
                'title' => $s->title,
                'type' => $s->type,
                'image' => $cleanServiceImage,
                'description' => $s->description,
                'price' => $s->price,
                'rating' => $s->rating ?? 0,
            ];

            // Put standalone services in appropriate tabs based on type
            $typeLower = strtolower($s->type);
            if ($typeLower === 'restaurant') {
                $groupedServices['restaurants'][] = $item;
            } elseif ($typeLower === 'guide') {
                $groupedServices['guides'][] = $item;
            } else {
                $groupedServices['activites'][] = $item; // Default to activities
            }
        }

        // 2. Add ALL Providers as main cards
        $this->hotels()->get()->each(function($h) use (&$groupedServices) {
            $groupedServices['hotels'][] = [
                'id' => 'provider-' . $h->id,
                'title' => $h->name ?? 'Hotel',
                'type' => $h->type,
                'image' => str_starts_with($h->image, 'http') ? $h->image : asset('storage/' . $h->image),
                'description' => $h->description,
                'price' => $h->price ?? 0,
                'rating' => 0,
                'is_provider_only' => true,
                'provider_id' => $h->id,
                'provider_type' => 'hotel'
            ];
        });

        $this->transports()->with('user')->get()->each(function($t) use (&$groupedServices) {
            $groupedServices['transport'][] = [
                'id' => 'provider-' . $t->id,
                'title' => $t->user->name ?? 'Transport',
                'type' => $t->type,
                'image' => str_starts_with($t->image, 'http') ? $t->image : asset('storage/' . $t->image),
                'description' => $t->description,
                'price' => $t->price ?? 0,
                'rating' => 0,
                'is_provider_only' => true,
                'provider_id' => $t->id,
                'provider_type' => 'transport'
            ];
        });

        $this->cooperatives()->get()->each(function($c) use (&$groupedServices) {
            $groupedServices['activites'][] = [
                'id' => 'provider-' . $c->id,
                'title' => $c->name ?? 'Cooperative',
                'type' => 'Cooperative',
                'image' => str_starts_with($c->image, 'http') ? $c->image : asset('storage/' . $c->image),
                'description' => $c->description,
                'price' => 0,
                'rating' => 0,
                'is_provider_only' => true,
                'provider_id' => $c->id,
                'provider_type' => 'cooperative'
            ];
        });

        return [
            'id' => $this->id,
            'title' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
            'coordinates' => $this->coordinates,
            'image' => (count($images) > 0) ? $images[0] : ($this->image ? (str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image)) : null),
            'images' => $images,
            'services' => $groupedServices,
            'favorite_id' => auth('sanctum')->check() 
                ? $this->favorites()->where('user_id', auth('sanctum')->id())->first()?->id 
                : null,
            'is_favorited' => auth('sanctum')->check() 
                ? $this->favorites()->where('user_id', auth('sanctum')->id())->exists() 
                : false,
            'rating_avg' => $this->average_rating,
            'total_ratings' => $this->total_votes,
            'user_rating' => auth('sanctum')->check()
                ? $this->ratings()->where('user_id', auth('sanctum')->id())->first()?->rating
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

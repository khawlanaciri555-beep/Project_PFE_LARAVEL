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

        $servicesRaw = $this->services()->with(['hotel', 'transport', 'cooperative'])->get();
        $groupedServices = [
            'guides' => [],
            'hotels' => [],
            'activites' => [],
            'restaurants' => [],
            'transport' => []
        ];

        foreach ($servicesRaw as $s) {
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

            if ($s->hotel_id) {
                // If it's linked to a hotel, we use the hotel type if available
                $item['hotel_type'] = $s->hotel ? $s->hotel->type : $s->type;
                $groupedServices['hotels'][] = $item;
            } elseif ($s->transport_id) {
                $groupedServices['transport'][] = $item;
            } else {
                $groupedServices['activites'][] = $item;
            }
        }

        // Add providers who don't have services yet
        $this->hotels()->whereDoesntHave('services')->get()->each(function($h) use (&$groupedServices) {
            $groupedServices['hotels'][] = [
                'id' => 'provider-' . $h->id,
                'title' => $h->user->name ?? 'Hotel',
                'type' => $h->type,
                'image' => str_starts_with($h->image, 'http') ? $h->image : asset('storage/' . $h->image),
                'description' => $h->description,
                'price' => $h->price,
                'rating' => 0,
                'is_provider_only' => true
            ];
        });

        $this->transports()->whereDoesntHave('services')->get()->each(function($t) use (&$groupedServices) {
            $groupedServices['transport'][] = [
                'id' => 'provider-' . $t->id,
                'title' => $t->user->name ?? 'Transport',
                'type' => $t->type,
                'image' => 'placeholder.jpg',
                'description' => $t->description,
                'price' => $t->price,
                'rating' => 0,
                'is_provider_only' => true
            ];
        });

        $this->cooperatives()->whereDoesntHave('services')->get()->each(function($c) use (&$groupedServices) {
            $groupedServices['activites'][] = [
                'id' => 'provider-' . $c->id,
                'title' => $c->name ?? 'Cooperative',
                'type' => 'Cooperative',
                'image' => str_starts_with($c->image, 'http') ? $c->image : asset('storage/' . $c->image),
                'description' => $c->description,
                'price' => 0,
                'rating' => 0,
                'is_provider_only' => true
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

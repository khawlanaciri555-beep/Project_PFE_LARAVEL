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

        if ($targetDir) {
            $files = \Illuminate\Support\Facades\Storage::disk('public')->files($targetDir);
            foreach ($files as $file) {
                // Ensure we only take image files
                if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                    $images[] = asset('storage/' . $file);
                }
            }
        }

        // Fallback to default image if no local images found
        if (empty($images) && $this->image) {
            $images[] = str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image);
        }

        return [
            'id' => $this->id,
            'title' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
            'coordinates' => $this->coordinates,
            'image' => (count($images) > 0) ? $images[0] : ($this->image ? (str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image)) : null),
            'images' => $images,
            'services' => [
                'guides' => [],
                'hotels' => [],
                'activites' => [],
                'restaurants' => [],
                'transport' => []
            ],
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

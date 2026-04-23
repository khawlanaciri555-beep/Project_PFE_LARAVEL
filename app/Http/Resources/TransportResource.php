<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->name ?? 'Provider', // Top level name for profile
            'type' => $this->type,
            'price' => $this->price,
            'availability' => $this->availability,
            'description' => $this->description,
            'phone' => $this->phone,
            'address' => $this->place?->name ?? 'Marrakech',
            'image' => $this->image ? (str_starts_with($this->image, 'http') ? $this->image : (str_starts_with($this->image, '/storage') ? $this->image : '/storage/' . ltrim($this->image, '/'))) : null,
            'license_doc' => $this->license_doc ? (str_starts_with($this->license_doc, 'http') ? $this->license_doc : (str_starts_with($this->license_doc, '/storage') ? $this->license_doc : '/storage/' . ltrim($this->license_doc, '/'))) : null,
            'is_deleted' => $this->is_deleted,
            'gallery' => $this->gallery ? array_map(function($item) {
                $path = is_array($item) ? ($item['url'] ?? '') : $item;
                if (!$path) return null;
                return str_starts_with($path, 'http') ? $path : (str_starts_with($path, '/storage') ? $path : '/storage/' . ltrim($path, '/'));
            }, array_filter($this->gallery)) : [],
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'user' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? null,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

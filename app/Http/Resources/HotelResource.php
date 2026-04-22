<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'image' => $this->image ? (str_starts_with($this->image, 'http') ? $this->image : (str_starts_with($this->image, '/storage') ? $this->image : '/storage/' . ltrim($this->image, '/'))) : null,
            'price' => $this->price,
            'description' => $this->description,
            'availability' => $this->availability,
            'is_deleted' => $this->is_deleted,
            'services' => $this->services,
            'gallery' => $this->gallery,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

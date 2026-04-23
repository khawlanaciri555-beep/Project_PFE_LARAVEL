<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'type' => $this->type,
            'rating' => $this->rating,
            'availability' => $this->availability,
            'price' => $this->price,
            'is_deleted' => $this->is_deleted,
            'cooperative' => new CooperativeResource($this->cooperative),
            'place' => new PlaceResource($this->place),
            'hotel' => new HotelResource($this->hotel),
            'transport' => new TransportResource($this->transport),
            'provider_id' => $this->hotel_id ?: ($this->transport_id ?: ($this->cooperative_id ?: null)),
            'provider_type' => $this->hotel_id ? 'hotel' : ($this->transport_id ? 'transport' : ($this->cooperative_id ? 'coop' : null)),
            'gallery' => $this->gallery, // Accessor from model
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

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
            'availability' => $this->availability,
            'price' => $this->price,
            'is_deleted' => $this->is_deleted,
            'cooperative' => new CooperativeResource($this->cooperative),
            'place' => new PlaceResource($this->place),
            'guide' => new GuideResource($this->guide),
            'hotel' => new HotelResource($this->hotel),
            'transport' => new TransportResource($this->transport),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

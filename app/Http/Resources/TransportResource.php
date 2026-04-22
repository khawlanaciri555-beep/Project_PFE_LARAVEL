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
            'type' => $this->type,
            'price' => $this->price,
            'availability' => $this->availability,
            'description' => $this->description,
            'phone' => $this->phone,
            'image' => $this->image ? (str_starts_with($this->image, 'http') ? $this->image : (str_starts_with($this->image, '/storage') ? $this->image : '/storage/' . ltrim($this->image, '/'))) : null,
            'license_doc' => $this->license_doc ? (str_starts_with($this->license_doc, 'http') ? $this->license_doc : (str_starts_with($this->license_doc, '/storage') ? $this->license_doc : '/storage/' . ltrim($this->license_doc, '/'))) : null,
            'is_deleted' => $this->is_deleted,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

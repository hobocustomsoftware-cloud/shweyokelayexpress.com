<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GateResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_my' => $this->name_my,
            'city_id' => $this->city_id,
            'description' => $this->description,
            'is_main' => $this->is_main,
            'is_transit' => $this->is_transit
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CarResource extends JsonResource
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
            'departure_date' => Carbon::parse($this->departure_date)->format('d-m-Y'),
            'number' => $this->number,
            'driver_name' => $this->driver_name,
            'driver_phone' => $this->driver_phone,
            'assistant_driver_name' => $this->assistant_driver_name,
            'assistant_driver_phone' => $this->assistant_driver_phone,
            'spare_name' => $this->spare_name,
            'spare_phone' => $this->spare_phone,
            'assistant_spare_name' => $this->assistant_spare_name,
            'assistant_spare_phone' => $this->assistant_spare_phone,
        ];
    }
}

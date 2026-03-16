<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UserResource;

class TransitPassengerResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'nrc' => $this->nrc,
            'car_id' => new CarResource($this->car),
            'seat_number' => $this->seat_number,
            'price' => $this->price,
            'transit_cargo_id' => new TransitCargoResource($this->transitCargo),
            'user' => new UserResource($this->user),
            'is_paid' => $this->is_paid,
            'status' => $this->status,
            'voucher_number' => $this->voucher_number,
            'date' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}

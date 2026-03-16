<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'quantity'       => $this->quantity,
            // CargoType နဲ့ Relationship ရှိရပါမယ်
            'cargo_type_id'  => $this->cargo_type_id,
            'cargo_type_name'=> optional($this->cargoType)->name ?? 'အထွေထွေ',
            'detail'         => $this->detail, // Database structure အရ
            'notice'         => $this->notice, // Database structure အရ
        ];
    }
}
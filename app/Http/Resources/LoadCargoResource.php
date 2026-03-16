<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CargoResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class LoadCargoResource extends JsonResource
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
            'cargo' => new CargoResource(optional($this->cargo)),
            'car' => new CarResource(optional($this->car)),
            'status' => $this->status,
            'assigned_date' => Carbon::parse($this->assigned_at)->format('d-m-Y'),
            'arrival_date' => Carbon::parse($this->arrived_at)->format('d-m-Y'),
            'user' => new UserResource(optional($this->user)),
        ];
    }
}

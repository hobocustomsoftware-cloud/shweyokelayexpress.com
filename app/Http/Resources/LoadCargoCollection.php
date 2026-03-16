<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LoadCargoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->total(),
                'totalPages' => $this->lastPage(),
                'currentPage' => $this->currentPage(),
                'perPage' => $this->perPage(),
                'links' => [
                    'next' => $this->nextPageUrl(),
                    'prev' => $this->previousPageUrl(),
                ],
            ]
        ];
    }
}

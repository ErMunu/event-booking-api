<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'description' => $this->description,
            'country' => $this->country,
            'date' => $this->date->format('Y-m-d'),
            'time' => $this->time->format('H:i'),
            'capacity' => $this->capacity,
            'available_spots' => $this->available_spots,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "class" => ClassesResource::make($this->whenLoaded("class")),
            "section" => ClassesResource::make($this->whenLoaded("section")),
            "created_at" => $this->created_at->toFormattedDateString(),
            // "created_at" => $this->created_at->diffForHumans(), // 1 hour ago (par exemple)
        ];
    }
}

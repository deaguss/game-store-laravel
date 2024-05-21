<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameDetailResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'imageUrl' => $this->imageUrl,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'developer' => $this->developer,
            'price' => $this->price ?? 'free',
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}

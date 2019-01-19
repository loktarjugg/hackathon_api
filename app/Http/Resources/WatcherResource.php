<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class WatcherResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'block_number' => $this->block_number,
            'sync_block_number' => $this->sync_block_number,
            'score' => $this->score,
            'events' => EventResource::collection($this->whenLoaded('events'))
        ];
    }
}

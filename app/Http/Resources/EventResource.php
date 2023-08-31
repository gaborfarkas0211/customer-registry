<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? '',
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->getType(),
        ];
    }
}

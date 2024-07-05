<?php

namespace App\Http\Resources;

use App\Enums\TaskStatus;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Task */
class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?? '',
            'status_id' => $this->status,
            'status' => TaskStatus::from($this->status)->getStatusName(),
            'expected_at' => $this->expected_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

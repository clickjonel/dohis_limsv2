<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreinspectionResource extends JsonResource
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
            'equipment' => $this->equipment,
            'model' => $this->model,
            'property_no' => $this->property_no,
            'acquisition_cost' => $this->acquisition_cost
        ];
    }
}

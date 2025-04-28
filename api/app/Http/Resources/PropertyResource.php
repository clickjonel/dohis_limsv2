<?php

namespace App\Http\Resources;

use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $property = [
            'property_no' => $this->property_no,
            'issuance_date' => $this->userHistory()->first()->issuance_date,
            'measurement_unit' => Measurement::find($this->measurement_unit),
            'particulars' => $this->particulars,
            'unit_cost' => $this->unit_cost,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'user' => UserResource::make($this->user),
            'user_history' => $this->userHistory,
        ];

        return $property;
    }
}

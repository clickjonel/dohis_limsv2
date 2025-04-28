<?php

namespace App\Http\Resources;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $property_user = [
            'id' => $this->id,
            'property_id' => PropertyResource::make(Property::find($this->property_id)),
            'user_id' => $this->user_id,
            'acquisition_date' => $this->acquisition_date,
            'return_date' => $this->return_date,
            'remarks' => $this->remarks,
        ];

        return $property_user;
    }
}

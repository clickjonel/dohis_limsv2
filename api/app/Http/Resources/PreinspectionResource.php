<?php

namespace App\Http\Resources;

use App\Models\Office;
use App\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreinspectionResource extends JsonResource
{
    use UserTrait;
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
            'acquisition_cost' => $this->acquisition_cost,
            'requested_by' => $this->getUserFullName($this->requestor),
            'date_requested' => $this->date,
            'defects' => $this->defects,
            'inspection_section' => Office::find($this->inspection_section)->section_name,
            'inspector_name' => $this->inspection_section === 25 ? $this->getUserFullName(15) : $this->getUserFullName(65),
            'inspector_position' => $this->inspection_section === 25 ? $this->getUserPosition(15) : $this->getUserPosition(65),
            'inspection_findings' => $this->findings,
            'inspection_result' => $this->inspection_result,
            'inspection_date' => $this->inspection_date,
            'property' => $this->property,
            'acquisition_date' => $this->acquisition_date
        ];
    }
}

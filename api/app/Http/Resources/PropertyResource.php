<?php

namespace App\Http\Resources;

use App\Models\Measurement;
use App\Models\Property;
use App\Models\User;
use App\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    use UserTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user->user_id);
        $user->full_name = $this->getUserFullName($user->user_id);

        $history = $this->userHistory->map(function($history) {
            return [
                'user_id' => $history->user_id,
                'full_name' => $this->getUserFullName($history->user_id),
                'acquisition_date' => $history->acquisition_date,
                'return_date' => $history->return_date,
                'remarks' => $history->remarks,
            ];
        });

        $currentInspection = $this->preInspection()->latest('created_at')->first();
        // $currentInspection['requestor_name'] = $this->getUserFullName($currentInspection['requestor']);

        $property = [
            'property_no' => $this->property_no,
            'issuance_date' => $this->userHistory()->first()->issuance_date,
            'measurement_unit' => Measurement::find($this->measurement_unit),
            'particulars' => $this->particulars,
            'unit_cost' => $this->unit_cost,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'user' => [
                'user' => $user,
                'acquisition_date' => $this->user->issuance_date,
            ],
            'user_history' => $history,
            'preInspections' => $this->preInspection,
            'currentPreinspection' => PreinspectionResource::make($currentInspection)
        ];

        return $property;
    }
}

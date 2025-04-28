<?php

namespace App\Http\Resources;

use App\Models\Designation;
use App\Models\Division;
use App\Models\EmploymentStatus;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assignment = [
            'assignment_id' => $this->user_assignment_id,
            'user' => UserResource::make(User::find($this->user_id)),
            'division' => Division::find($this->division_id),
            'section' => Office::find($this->section_id),
            'designation' => Designation::find($this->designation_id),
            'employment_status' => EmploymentStatus::find($this->employee_status_id),
        ];
        
        return $assignment;
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyTransferRequestResource extends JsonResource
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
            'transfer_to' => UserResource::make(User::find($this->transfer_to)),
            'requested_by' => UserResource::make(User::find($this->requested_by)),
            'date_requested' => $this->date_requested,
            'property' => PropertyResource::make(Property::find($this->property_id)),
            'transfer_reason' => $this->transfer_reason,
            'pc_request_approved' => $this->pc_request_approved === 1 ? true : ($this->pc_request_approved === null ? null : false),
            'pc_request_approved_date' => $this->pc_request_approved_date,
            'pc_request_rejection_reason' => $this->pc_request_rejection_reason,
            'status' => $this->status,
            'next_step' => $this->status === 'PC Approved' ? 'Pending Approval of MSD Division Head' : ''
        ];

        return $property_user;
    }
}

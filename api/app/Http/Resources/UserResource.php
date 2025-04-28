<?php

namespace App\Http\Resources;

use App\Models\UserAssignment;
use App\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use UserTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $user = [
            'user_id' => $this->user_id,
            'user_name' => $this->getUserFullName($this->user_id),
            'user_position' => $this->getUserPosition($this->user_id),
            'user_assignment' => UserAssignment::where('user_id', $this->user_id)->latest('created_at')->first(),
        ];

        return $user;
    }
}

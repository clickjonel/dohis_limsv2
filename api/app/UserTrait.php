<?php

namespace App;

use App\Models\User;
use App\Models\UserAssignment;
use App\Models\UserPosition;

trait UserTrait
{
    public function getUserFullName($user_id)
    {
        $user = User::find($user_id);
        $middle_initial = $user->middle_name ? substr($user->middle_name, 0, 1) . '.' : '';
        $full_name = "{$user->prefix} {$user->first_name} {$middle_initial} {$user->last_name} {$user->suffix}";
        
        return $full_name;
    }

    public function getUserPosition($user_id)
    {
        $assignment = UserAssignment::where('user_id',$user_id)->latest('created_at')->first();
        $position = UserPosition::find($assignment->item_id)->plantilla_title;
        
        return $position;
    }

    public function getUserDivisionChief($user_id)
    {
        $user_assignment = UserAssignment::where('user_id',$user_id)->latest('created_at')->first();
        $division_chief_assignment = UserAssignment::where('designation_id',3)->where('division_id',$user_assignment->division_id)->first();

        return $this->getUserFullName($division_chief_assignment->user_id);
    }

    public function getUserSectionID($user_id)
    {
        $user_assignment = UserAssignment::where('user_id',$user_id)->latest('created_at')->first();

        return  $user_assignment->section_id;
    }

    public function getUserRoles($user_id)
    {
        $user_assignment = UserAssignment::where('user_id',$user_id)->latest('created_at')->first();

        $is_permanent = $user_assignment->employee_status_id === 1 ? true : false;
        $is_supply_officer = $user_assignment->section_id === 28 ? true : false;

        $roles = [
            $is_permanent ? 'permanent' : 'contractual',
            $is_supply_officer ? 'supply_officer' : 'non_supply_officer',
        ];

        return $roles;
    }

}

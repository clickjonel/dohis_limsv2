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

        $roles = ['user'];

        $is_permanent = $user_assignment->employee_status_id === 1 ? $roles[] = 'permanent' : [];
        $is_supply_officer = $user_assignment->section_id === 28 ? $roles[] = 'supply_officer' : [];
        $is_superadmin = $user_id === 582 ? $roles[] = 'superadmin' : [];
        
        return $roles;
    }

}

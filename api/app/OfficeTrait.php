<?php

namespace App;

use App\Models\Office;

trait OfficeTrait
{
    use UserTrait;

    public function findOffice($office_id)
    {
        $office = Office::find($office_id);

        return $office;
    }

    public function fetchOfficePersonnel($office_id)
    {
        $office = $this->findOffice($office_id);
       
        return $office->personnel->map(function($user){
            return [
                'user_id' => $user->user_id,
                'full_name' => $this->getUserFullName($user->user_id)
            ];
        });
    }
}

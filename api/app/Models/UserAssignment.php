<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssignment extends Model
{
    protected $connection = 'dohis';
    protected $table = 'dohis_user_assignment';
    protected $primaryKey = 'user_assignment_id';
}

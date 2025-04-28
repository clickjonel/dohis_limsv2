<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    protected $connection = 'dohis';
    protected $table = 'dohis_employee_status';
    public $timestamps = false;

    protected $primaryKey = 'employee_status_id';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreinspectionRequest extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_preinspection_requests';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreinspectionRequest extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_preinspection_requests';

    protected $fillable = [
        'equipment',
        'model',
        'property_no',
        'acquisition_cost',
        'acquisition_date',
        'defects',
        'requestor',
        'findings',
        'inspection_section',
        'inspection_result',
        'date'
    ];
}

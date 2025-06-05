<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'inspection_date',
        'date',
        'status'
    ];

    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_no', 'property_no');
    }
}

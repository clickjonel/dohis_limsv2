<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInspectionRequest extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_property_inspection_requests';

    protected $fillable = [
        'property_id',
        'request_date',
        'requested_by',
        'defects',
        'inspection_section',
        'inspection_result',
        'inspection_findings',
        'inspection_date',
        'status',
    ];

    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

}

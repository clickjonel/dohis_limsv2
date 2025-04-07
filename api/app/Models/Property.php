<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_properties';
    public $timestamps = false;

    protected $fillable = [
        'property_no',
        'issuance_date',
        'measurement_unit',
        'particulars',
        'unit_cost',
        'status',
        'remarks'
    ];

    public function user()
    {
        return $this->hasOne(PropertyUser::class, 'property_id');
    }
}

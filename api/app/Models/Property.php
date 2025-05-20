<?php

namespace App\Models;

use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection as SupportCollection;

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
        'remarks',
        'acquisition_date'
    ];

    public const STATUSES = [
        ['name'=>'Active'],
        ['name'=>'Wasted'],
        ['name'=>'Disposed'],
        ['name'=>'Transfer Approval Pending'],
    ];

    public function user()
    {
        return $this->hasOne(PropertyUser::class, 'property_id');
    }

    public function userHistory()
    {
        return $this->hasMany(PropertyUserHistory::class, 'property_id');
    }

    public function preInspection(): HasMany
    {
        return $this->hasMany(PreinspectionRequest::class, 'property_no', 'property_no');
    }

    public function measurement(): HasOne
    {
        return $this->hasOne(Measurement::class, 'id', 'measurement_unit');
    }


}

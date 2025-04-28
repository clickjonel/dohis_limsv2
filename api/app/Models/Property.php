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
        'remarks',
        'acquisition_date'
    ];

    public const STATUSES = [
        ['name'=>'Active'],
        ['name'=>'Wasted'],
        ['name'=>'Disposed'],
    ];

    public function user()
    {
        return $this->hasOne(PropertyUser::class, 'property_id');
    }

    public function userHistory()
    {
        return $this->hasMany(PropertyUserHistory::class, 'property_id');
    }

    public static function getStatus($status_name){
        $status = collect(self::STATUSES)->firstWhere('name', $status_name);
        return $status;
    }

}

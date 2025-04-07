<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyUser extends Model
{
    protected $connection = 'lims';
    protected $table = 'property_user';
    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'user_id',
        'issuance_date',
    ];

}

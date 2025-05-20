<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class,'property_id','id');
    }

}

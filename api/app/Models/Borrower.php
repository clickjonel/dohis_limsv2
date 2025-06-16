<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrower extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_property_borrowers';

    public $timestamps = false;
    protected $fillable = [
        'property_id',
        'borrower_id',
        'borrow_date',
        'return_date'
    ];

    public function property():HasOne
    {
        return $this->hasOne(Property::class,'id','property_id');
    }

    public function borrower():HasOne
    {
        return $this->hasOne(User::class,'user_id','borrower_id');
    }
}

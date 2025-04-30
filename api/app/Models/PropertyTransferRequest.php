<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTransferRequest extends Model
{
    protected $connection = 'lims';
    protected $table = 'property_transfer_requests';
    public $timestamps = false;

    protected $fillable = [
        'requested_by',
        'transfer_to',
        'itr_no',
        'transfer_type',
        'date_requested',
        'transfer_reason',
        'property_id',
        'pc_request_approved',
        'pc_request_approved_date',
        'approved_by',
        'approved_date',
        'issued_by',
        'issued_date',
        'status',
        'pc_request_rejection_reason',
    ];
}

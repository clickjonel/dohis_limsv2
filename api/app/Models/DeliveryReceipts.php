<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryReceipts extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_delivery_receipts';
    public $timestamps = false;

    protected $fillable = [
        'delivery_id',
        'dr_no',
        'dr_date',
        'delivery_date',
        'delivery_place'
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}

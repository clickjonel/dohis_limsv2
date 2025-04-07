<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delivery extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_deliveries';
    protected $fillable = [
        'hashid',
        'entity_name',
        'fund_source',
        'source_name',
        'source_address',
        'iar_no',
        'iar_date',
        'po_no',
        'po_date',
        'ptr_no',
        'ptr_date',
        'bl_no',
        'bl_date',
        'dnf_no',
        'dnf_date',
        'req_office',
        'end_user',
        'payment_term',
        'completion',
        'purpose',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(DeliveryInvoice::class, 'delivery_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(DeliveryReceipts::class, 'delivery_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, 'delivery_id');
    }
}

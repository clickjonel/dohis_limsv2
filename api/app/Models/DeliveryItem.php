<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeliveryItem extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_delivery_items';
    public $timestamps = false;

    protected $fillable = [
        'delivery_id',
        'availability',
        'manufacturer',
        'manufacturing_date',
        'expiry_date',
        'unit_cost',
        'quantity',
        'batch_lot_number',
        'shelf_life',
        'measurement_unit',
        'description',
    ];

    public function measurementUnit():HasOne
    {
        return $this->hasOne(Measurement::class,'id','measurement_unit');
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
}

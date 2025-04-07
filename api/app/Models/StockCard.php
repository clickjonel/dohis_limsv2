<?php

namespace App\Models;

use App\Models\StockCardTransaction;
use Illuminate\Database\Eloquent\Model;

class StockCard extends Model
{
    protected $connection = 'lims';
    protected $table = 'lims_stock_cards';
    public $timestamps = false;

    protected $fillable = [
        'stock_no',
        'stock_name',
        'contract_no',
        'entity_name',
        'iar_no',
        'supplier_name',
        'supplier_address',
        'item_description',
        'dosage_form',
        'dosage_strength',
        'measurement_unit',
        'unit_cost',
        'procurement_mode',
        'fund_cluster',
        'warehouse',
        'batch_no',
        'expiry_date',
        'category',
        'req_office',
        'quantity',
    ];

    public function transactions()
    {
        return $this->hasMany(StockCardTransaction::class, 'stock_card_id');
    }

    public function latestTransaction()
    {
        return $this->transactions()->latest('id')->first();
    }
}

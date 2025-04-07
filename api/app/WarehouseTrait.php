<?php

namespace App;

use App\Models\Warehouse;

trait WarehouseTrait
{
    public function getWarehouseName($warehouse_id)
    {
        $warehouse = Warehouse::find($warehouse_id);
        
        return $warehouse->name;
    }
}

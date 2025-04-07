<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;


trait DeliveryTrait
{
    public function getDeliveryTotalByMonth(Collection $receipts): Collection
    {
        $counts = $receipts
            ->groupBy(function ($receipt) {
                return Carbon::parse($receipt->delivery_date)->month;
            })
            ->map->count();

        return collect(range(1, 12))->mapWithKeys(function ($month) use ($counts) {
            $monthName = Carbon::create()->month($month)->format('F');
            return [$monthName => $counts->get($month, 0)];
        });
    }

}

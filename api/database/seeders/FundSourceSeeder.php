<?php

namespace Database\Seeders;

use App\Models\FundSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fund_sources = [
           [
                'name' => '[01] - Regular Agency Fund',
                'code' => '01'
           ],
           [
                'name' => '[02] - Foreign Assisted Project Fund',
                'code' => '02'
           ],
           [
                'name' => '[03] - Special Account - Locally Funded',
                'code' => '03'
           ],
           [
                'name' => '[04] - Special Account - Foreign Assisted/Grants',
                'code' => '04'
           ],
           [
                'name' => '[05] - Internally Generated Income',
                'code' => '05'
           ],
           [
                'name' => '[06] - Business Type Income',
                'code' => '06'
           ],
           [
                'name' => '[07] - Trust Receipt',
                'code' => '07'
           ],
        ];

        foreach($fund_sources as $fund_source){
            FundSource::create([
                'name' => $fund_source['name'],
                'code' => $fund_source['code']
            ]);
        }
    }
}

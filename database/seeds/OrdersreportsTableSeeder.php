<?php

use App\Models\Ordersreports\Ordersreports;
use Illuminate\Database\Seeder;

class OrdersreportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'title' => 'All orders',
                'desc' => 'All orders in the shop',
                'number' => 'R01',
                'apislug' => 'r01',
            ],
            [
                'title' => 'Completed orders',
                'desc' => 'All completed orders in a date range',
                'number' => 'R02',
                'apislug' => 'r02',
            ],
            [
                'title' => 'All items',
                'desc' => 'All items in the shop',
                'number' => 'D02',
                'apislug' => 'd02',
            ],
        ];

        foreach ($countries as $report){
            Ordersreports::create($report);
        }
    }
}

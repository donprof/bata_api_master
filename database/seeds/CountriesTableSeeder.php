<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Naivasha' => 'NV',
            'Nairobi' => 'NR',
            'Limuru' => 'LM',
            'Karen' => 'KR',
            'Westlands' => 'WL',
            'Parklands' => 'PK'
        ];

        collect($countries)->each(function ($code, $name) {
            Country::create([
                'code' => $code,
                'name' => $name,
            ]);
        });
    }
}

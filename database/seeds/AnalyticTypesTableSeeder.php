<?php

use Illuminate\Database\Seeder;

class AnalyticTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        $aAnalyticTypes = array (
            0 =>
            array (
                'id' => 1,
                'name' => 'max_Bld_Height_m',
                'units' => 'm',
                'is_numeric' => 1,
                'num_decimal_places' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'min_lot_size_m2',
                'units' => 'm2',
                'is_numeric' => 1,
                'num_decimal_places' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'fsr',
                'units' => ':1',
                'is_numeric' => 1,
                'num_decimal_places' => 2,
            ),
        );

        foreach ($aAnalyticTypes as $key => $aAnalyticType) {
            \App\Models\AnalyticType::create($aAnalyticType);
        }
    }
}

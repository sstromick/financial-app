<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use DB;

class IncomeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Config::get('field_values.incomes.income_type');

        if (!empty($types)) {
            foreach ($types as $title => $type) {
                $data = [
                    'income_type' => $title,
                ];

                if (!empty($type['image'])) {
                    $data['image'] = $type['image'];
                }

                if (!empty($type['description'])) {
                    $data['description'] = $type['description'];
                }

                if (!empty($type['swagger_api_type'])) {
                    $data['swagger_api_type'] = $type['swagger_api_type'];
                }

                if (!empty($type['swagger_api_detail'])) {
                    $data['swagger_api_detail'] = $type['swagger_api_detail'];
                }

                DB::table('income_types')->insertGetId($data);
            }
        }
    }
}

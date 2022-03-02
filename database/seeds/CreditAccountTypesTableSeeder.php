<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use DB;
use Illuminate\Support\Facades\Log;

class CreditAccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Config::get('field_values.credit_accounts.debt_type');

        if (!empty($types)) {
            //$types = array_keys($types);

            foreach ($types as $type) {
                $data = [
                    'debt_type' => $type['name'],
                ];

                if (!empty($type['swagger_api_category'])) {
                    $data['swagger_api_category'] = $type['swagger_api_category'];
                }
                if (!empty($type['swagger_api_type'])) {
                    $data['swagger_api_type'] = $type['swagger_api_type'];
                }
                if (!empty($type['swagger_api_detail'])) {
                    $data['swagger_api_detail'] = $type['swagger_api_detail'];
                }

                DB::table('credit_account_types')->insertGetId($data);
            }
        }
    }
}

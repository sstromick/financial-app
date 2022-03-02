<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use DB;

class ExpenseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Config::get('field_values.expenses.expense_type');

        if (!empty($categories)) {
            $categoryKeys = array_keys($categories);

            foreach ($categoryKeys as $key) {
                $image = $categories[$key]['image'];

                $data = [
                    'expense_category' => $key,
                ];

                if (!empty($image)) {
                    $data['image'] = $image;
                }

                DB::table('expense_categories')->insertGetId($data);
            }
        }

    }
}

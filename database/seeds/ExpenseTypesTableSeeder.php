<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use DB;

class ExpenseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get outermost array of expense categories
        $expenseCategories = Config::get('field_values.expenses.expense_type');

        if (!empty($expenseCategories)) {

            // Get just first level category names
            $categories = array_keys($expenseCategories);

            foreach ($categories as $category) {

                // Get the category array of expense types
                $types = $expenseCategories[$category]['types'];

                // Find the expense category using the category name
                $entry = DB::table('expense_categories')->where('expense_category', $category)->first();

                // Get expense category ID for foreign key in expense type table
                $category_id = $entry->id;

                foreach ($types as $type) {
                    if (isset($type['detail']))
                        DB::table('expense_types')->insertGetId(['category_id' => $category_id, 'expense_type' => $type['name'], 'swagger_api_type' => $type['type'], 'swagger_api_detail' => $type['detail']]);
                    else
                        DB::table('expense_types')->insertGetId(['category_id' => $category_id, 'expense_type' => $type['name'], 'swagger_api_type' => $type['type']]);
                }
            }
        }
    }
}

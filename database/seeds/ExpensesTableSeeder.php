<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use App\Expense;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number_of_test_records = Config::get('tinker.number_of_test_users');
        factory(Expense::class, $number_of_test_records * 2)->create();
    }
}

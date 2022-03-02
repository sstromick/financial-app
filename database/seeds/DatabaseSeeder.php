<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UsersTableSeeder::class,
            SubmissionsTableSeeder::class,
            ExpenseCategoriesTableSeeder::class,
            ExpenseTypesTableSeeder::class,
            IncomeTypesTableSeeder::class,
            CreditAccountTypesTableSeeder::class,
            //ExpensesTableSeeder::class,
            SubmissionReasonsTableSeeder::class,
            USStatesTableSeeder::class,
        ]);
    }
}

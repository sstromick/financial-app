<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use App\Submission;

class SubmissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number_of_test_records = Config::get('tinker.number_of_test_users');
        factory(Submission::class, $number_of_test_records)->create();
    }
}

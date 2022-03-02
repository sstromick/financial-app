<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Expense::class, function (Faker $faker) {
    $types = [];
    $expense_categories = Config::get('field_values.expenses.expense_type');

    foreach ($expense_categories as $category) {
        foreach ($category['types'] as $type) {
            $types[] = $type['name'];
        }
    }

    $number_of_test_users = Config::get('tinker.number_of_test_users');

    return [
        // There can be many expenses per submission, so no unique() needed
        'submission_id' => $faker->numberBetween(1, $number_of_test_users),
        'expense_type' => $faker->randomElement($types),
        'expense_value' => $faker->numberBetween(10, 500),
        'created_at' => now(),
        'updated_at' => now(),
        'deleted_at' => null,
    ];
});

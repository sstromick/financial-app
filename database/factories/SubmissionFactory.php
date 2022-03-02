<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Submission;
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

$factory->define(Submission::class, function (Faker $faker) {
    $submission_types = Config::get('field_values.submission.submission_type');
    $submission_reasons = array_keys(Config::get('field_values.submission.reason'));

    $number_of_test_users = Config::get('tinker.number_of_test_users');

    $use_second_address = random_int(0, 1);
    $second_address = $use_second_address ? $faker->secondaryAddress : '';

    $gross_employment_income = $faker->numberBetween(5000, 80000);

    $credit_approval = random_int(0, 1);
    // If approved, make a date
    $credit_approval_at = $credit_approval ? $faker->dateTime('now') : null;

    $counseling_approval = random_int(0, 1);
    // If approved, make a date
    $counseling_approval_at = $counseling_approval ? $faker->dateTime('now') : null;

    $bankruptcy_approval = random_int(0, 1);
    // If approved, make a date
    $bankruptcy_approval_at = $bankruptcy_approval ? $faker->dateTime('now') : null;

    $use_co_second_address = random_int(0, 1);
    $co_second_address = $use_co_second_address ? $faker->secondaryAddress : '';

    return [
        'user_id' => $faker->unique()->numberBetween(1, $number_of_test_users),
        'submission_type' => $faker->randomElement($submission_types),
        'reason' => $faker->randomElement($submission_reasons),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $second_address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'income_dependents' => $faker->randomDigit,
        'gross_employment_income' => $gross_employment_income,
        'net_employment_income' => $faker->numberBetween(0, $gross_employment_income),
        'self_employment_income' => $faker->numberBetween(0, 80000),
        'benefits_income' => $faker->numberBetween(0, 2000),
        'retirement_income' => $faker->numberBetween(0, 2000),
        'social_security_income' => $faker->numberBetween(0, 2000),
        'pension_income' => $faker->numberBetween(0, 80000),
        'other_income' => $faker->numberBetween(0, 80000),
        'ssn' => $faker->unique()->ssn,
        'co_applicant_first_name' => $faker->firstName,
        'co_applicant_last_name' => $faker->lastName,
        'co_applicant_ssn' => $faker->unique()->ssn,
        'co_applicant_address_line_1' => $faker->streetAddress,
        'co_applicant_address_line_2' => $co_second_address,
        'co_applicant_city' => $faker->city,
        'co_applicant_state' => $faker->state,
        'co_applicant_zip' => $faker->postcode,
        'bankruptcy_session_time' => $faker->numberBetween(0, 360000),
        'credit_approval' => $credit_approval,
        'credit_approval_at' => $credit_approval_at,
        'counseling_approval' => $counseling_approval,
        'counseling_approval_at' => $counseling_approval_at,
        'bankruptcy_approval' => $bankruptcy_approval,
        'bankruptcy_approval_at' => $bankruptcy_approval_at,
        'ip_address' => $faker->ipv4,
        'created_at' => now(),
        'updated_at' => now(),
        'deleted_at' => null,
    ];
});

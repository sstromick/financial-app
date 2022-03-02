<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Config;
use DB;

class SubmissionReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = Config::get('field_values.submission.reason');

        if (!empty($reasons)) {
            foreach ($reasons as $title => $reason) {
                $data = [
                    'reason' => $title,
                ];

                if (!empty($reason['image'])) {
                    $data['image'] = $reason['image'];
                }

                if (!empty($reason['description'])) {
                    $data['description'] = $reason['description'];
                }

                DB::table('submission_reasons')->insertGetId($data);
            }
        }

    }
}

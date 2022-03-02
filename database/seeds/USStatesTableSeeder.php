<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\USState;

class USStatesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        USState::create(['name' => 'Alaska', 'code' => 'AK']);
        USState::create(['name' => 'Alabama', 'code' => 'AL']);
        USState::create(['name' => 'Arizona', 'code' => 'AZ']);
        USState::create(['name' => 'Arkansas', 'code' => 'AR']);
        USState::create(['name' => 'California', 'code' => 'CA']);
        USState::create(['name' => 'Colorado', 'code' => 'CO']);
        USState::create(['name' => 'Connecticut', 'code' => 'CT']);
        USState::create(['name' => 'Delaware', 'code' => 'DE']);
        USState::create(['name' => 'Florida', 'code' => 'FL']);
        USState::create(['name' => 'Georgia', 'code' => 'GA']);
        USState::create(['name' => 'Hawaii', 'code' => 'HI']);
        USState::create(['name' => 'Idaho', 'code' => 'ID']);
        USState::create(['name' => 'Illinois', 'code' => 'IL']);
        USState::create(['name' => 'Indiana', 'code' => 'IN']);
        USState::create(['name' => 'Iowa', 'code' => 'IA']);
        USState::create(['name' => 'Kansas', 'code' => 'KS']);
        USState::create(['name' => 'Kentucky', 'code' => 'KY']);
        USState::create(['name' => 'Louisiana', 'code' => 'LA']);
        USState::create(['name' => 'Maine', 'code' => 'ME']);
        USState::create(['name' => 'Maryland', 'code' => 'MD']);
        USState::create(['name' => 'Massachusetts', 'code' => 'MA']);
        USState::create(['name' => 'Michigan', 'code' => 'MI']);
        USState::create(['name' => 'Minnesota', 'code' => 'MN']);
        USState::create(['name' => 'Mississippi', 'code' => 'MS']);
        USState::create(['name' => 'Missouri', 'code' => 'MO']);
        USState::create(['name' => 'Montana', 'code' => 'MT']);
        USState::create(['name' => 'Nebraska', 'code' => 'NE']);
        USState::create(['name' => 'Nevada', 'code' => 'NV']);
        USState::create(['name' => 'New Hampshire', 'code' => 'NH']);
        USState::create(['name' => 'New Jersey', 'code' => 'NJ']);
        USState::create(['name' => 'New Mexico', 'code' => 'NM']);
        USState::create(['name' => 'New York', 'code' => 'NY']);
        USState::create(['name' => 'North Carolina', 'code' => 'NC']);
        USState::create(['name' => 'North Dakota', 'code' => 'ND']);
        USState::create(['name' => 'Ohio', 'code' => 'OH']);
        USState::create(['name' => 'Oklahoma', 'code' => 'OK']);
        USState::create(['name' => 'Oregon', 'code' => 'OR']);
        USState::create(['name' => 'Pennsylvania', 'code' => 'PA']);
        USState::create(['name' => 'Rhode Island', 'code' => 'RI']);
        USState::create(['name' => 'South Carolina', 'code' => 'SC']);
        USState::create(['name' => 'South Dakota', 'code' => 'SD']);
        USState::create(['name' => 'Tennessee', 'code' => 'TN']);
        USState::create(['name' => 'Texas', 'code' => 'TX']);
        USState::create(['name' => 'Utah', 'code' => 'UT']);
        USState::create(['name' => 'Vermont', 'code' => 'VT']);
        USState::create(['name' => 'Virginia', 'code' => 'VA']);
        USState::create(['name' => 'Washington', 'code' => 'WA']);
        USState::create(['name' => 'West Virginia', 'code' => 'WV']);
        USState::create(['name' => 'Wisconsin', 'code' => 'WI']);
        USState::create(['name' => 'Wyoming', 'code' => 'WY']);
    }
}
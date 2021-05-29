<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groupuser;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
Use \Carbon\Carbon;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meetings')->delete();
        DB::table('meetings')->insert([
            [
                'name' => 'Meeting1 Laravel',
                'group_id' => '1',
                'location' => 'Berlin',
                'start_time' => date('Y-m-d H:i:s'),
                'end_time' => date('Y-m-d H:i:s'),
                'hidden' => '1' ,                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meeting2 React',
                'group_id' => '2',
                'location' => 'Chemnitz',
                'start_time' => Carbon::tomorrow()->toDateTimeString(),
                'end_time' => Carbon::tomorrow()->add(1, 'hour')->toDateTimeString(),
                'hidden' => '0' ,                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meeting3 Php',
                'group_id' => '3',
                'location' => 'Dresden',
                'start_time' => Carbon::tomorrow()->toDateTimeString(),
                'end_time' => Carbon::tomorrow()->add(1, 'hour')->toDateTimeString(),
                'hidden' => '0' ,                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}

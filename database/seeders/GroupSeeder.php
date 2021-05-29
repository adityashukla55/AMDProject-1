<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();
        DB::table('groups')->insert([

            [
                'topic' => 'Group1-Laravel',
                'description' => 'group11111',
                'user_id' => '3',
                'count_limit' => '100000000',
                'filled' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'topic' => 'Group2-Laravel',
                'description' => 'group22222',
                'user_id' => '4',
                'count_limit' => '4',
                'filled' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'topic' => 'Group3-Php',
                'description' => 'group3333',
                'user_id' => '5',
                'count_limit' => '2',
                'filled' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
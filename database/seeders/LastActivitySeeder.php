<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('last_activity')->insert([
              'user_id' => 32,
              'etat_user' => 0,
              'status_activity' => 0,
              'date_activity' => '2021-12-30 16:54:21'
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // for ($i=1; $i < 7; $i++) { 
        User::create([
            'name' => 'testeur',
            'email' => 'testeur@test.co',
            'password' => Hash::make('testeur'),
        ]);
      //  }
    }
}

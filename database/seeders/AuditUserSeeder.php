<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserExterne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class AuditUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 7; $i++) { 
            UserExterne::create([
                'nom' => 'monnom'.$i,
                'prenoms' => 'monprenoms'.$i,
                'email' => 'monemail'.$i,
                'entreprise' => 'monentreprise'.$i
            ]);
        }
    }
}

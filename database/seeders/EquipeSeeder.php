<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Equipe;
use Illuminate\Support\Str;
use App\Http\Traits\CodeSecret;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    use CodeSecret;

    public function run()
    {    

        for ($i=1; $i < 11; $i++) { 
            Equipe::create([
                'libelle_equipe' => "equipe(".$i.")",
                'code_equipe' => strtoupper(Str::random(4)),
            ]);
        }

    }
}

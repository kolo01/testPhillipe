<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperateurController extends Controller
{
    public function operateur()
    {   
        $operateurs = DB::table('operateurs')->get();

        return view('operateur.liste-operateur', compact('operateurs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Traits\fondManager;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marchand;

class DashboardController extends Controller
{   
    use fondManager;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {   
        $marchand =  Marchand::find(auth()->user()->marchand_id);
        $nom_marchand = $marchand->nom; 
        $marchand_id = $marchand->id; 
        $service_status = $marchand->service_status; 
        
        if(auth()->user()->role == 'superAdmin'){
            if ($service_status == 1) {
                $transactions = DB::connection('mysql2')->table('transactions')->get()->count();
                $total_success = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'SUCCESS')->get()->count();
                $total_failed = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'FAILED')->get()->count();
                $solde = DB::connection('mysql2')->table('transactions')->where('type','depot')->where('statut', '=', 'SUCCESS')->sum('transacmontant');
            } else {
                $transactions = Transaction::where('marchand_id', '!=', '')->get()->count();
                $total_success = Transaction::where('statut', '=', 'SUCCESS')->get()->count();
                $total_failed = Transaction::where('statut', '=', 'FAILED')->get()->count();
                $solde = $this->GsoldeCompte();
            }
        }else{
            if ($service_status == 1) {
                $transactions = DB::connection('mysql2')->table('transactions')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_success = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_failed = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'FAILED')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $solde = DB::connection('mysql2')->table('transactions')->where('type','depot')->where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->sum('transacmontant');
            } else {
                $transactions = Transaction::where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_success = Transaction::where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_failed = Transaction::where('statut', '=', 'FAILED')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $solde = $this->soldeCompte();
            }
        }


        return view('dashboard.dashboard', [
            'transactions' =>  $transactions,
            'total_success' =>  $total_success,
            'total_failed' =>  $total_failed,
            'montant_total' =>  $solde
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

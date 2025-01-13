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
        ini_set('max_execution_time', '600');
       // $transactions = Transaction::where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
        //$total_success = Transaction::where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
       // $total_failed = Transaction::where('statut', '=', 'FAILED')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
        //$solde = $this->soldeCompte();
        $marchand =  Marchand::find(auth()->user()->marchand_id);
        $nom_marchand = $marchand->nom;
        $marchand_id = $marchand->id;
        $service_status = $marchand->service_status;
        //$this->soldeTransaction(auth()->user()->marchand_id), $this->soldeRetrait(auth()->user()->marchand_id))
        if(auth()->user()->role == 'superAdmin'){
            $t = $this->GsoldeTransaction() - $this->GsoldeRetrait();
            if ($service_status == 1) {
                $graph = DB::table('view_graph_t_last_30_days')->get();
                $transactions = DB::connection('mysql2')->table('transactions')->get()->count();
                $total_success = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'SUCCESS')->get()->count();
                $total_failed = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'FAILED')->get()->count();
<<<<<<< HEAD
                $solde = '0';
=======
                $solde = '0';//DB::connection('mysql2')->table('transactions')->where('type','depot')->where('statut', '=', 'SUCCESS')->sum('transacmontant');
>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
            } else {
                $graph = DB::table('view_graph_t_last_30_days')->get();
                $transactions = Transaction::where('marchand_id', '!=', '')->get()->count();
                $total_success = Transaction::where('statut', '=', 'SUCCESS')->get()->count();
                $total_failed = Transaction::where('statut', '=', 'FAILED')->get()->count();
                $solde = $t;
<<<<<<< HEAD
=======

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
            }
        }else{
            if ($service_status == 1) {
                $graph = DB::table('transactions')
                ->select(DB::raw('CAST(created_at AS DATE) AS transaction_date'), DB::raw('COUNT(*) AS transaction_count'))
                ->where('statut', 'SUCCESS')
                ->where('marchand_id', '29')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy(DB::raw('CAST(created_at AS DATE)'))
                ->orderBy(DB::raw('CAST(created_at AS DATE)'), 'desc')
                ->get();
                $transactions = DB::connection('mysql2')->table('transactions')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_success = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_failed = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'FAILED')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $solde = DB::connection('mysql2')->table('transactions')->where('statut', '=', 'SUCCESS')->where('type','depot')->where('marchand_id', '=', auth()->user()->marchand_id)->sum('transacmontant');
            } else {
                $graph = DB::table('transactions')
                ->select(DB::raw('CAST(created_at AS DATE) AS transaction_date'), DB::raw('COUNT(*) AS transaction_count'))
                ->where('statut', 'SUCCESS')
<<<<<<< HEAD
                ->where('marchand_id', '29')
=======
                ->where('marchand_id', auth()->user()->id)
>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy(DB::raw('CAST(created_at AS DATE)'))
                ->orderBy(DB::raw('CAST(created_at AS DATE)'), 'desc')
                ->get();
                $transactions = Transaction::where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_success = Transaction::where('statut', '=', 'SUCCESS')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $total_failed = Transaction::where('statut', '=', 'FAILED')->where('marchand_id', '=', auth()->user()->marchand_id)->get()->count();
                $solde = $this->soldeTransaction(auth()->user()->marchand_id) - $this->soldeRetrait(auth()->user()->marchand_id);
            }
        }
<<<<<<< HEAD
        
=======

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
        $graphs = $graph->map(function($item) {
            $dateTimeParts = explode('T', $item->transaction_date);
            $datePart = $dateTimeParts[0];
            $t = explode('-', $datePart);
            $j = explode(' ', $t[2]);
            $item->date = $j[0]."-".$t[1]."-".$t[0];
            return $item;
        });
<<<<<<< HEAD
        
=======

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1

        $mapData = [
            "dep" => $graphs->toArray(),
        ];

        return view('dashboard.dashboard', [
            'transactions' =>  $transactions,
            'total_success' =>  $total_success,
            'total_failed' =>  $total_failed,
            'montant_total' =>  $solde,
            'mapData' =>  $mapData
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

    public function soldeTransaction($marchand_id){

        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','depot')->where('marchand_id', '=', $marchand_id)->get();

       if ($montant_total->count() == 0 || $montant_total->count() == null) {
           $mt = 0;
       }else {
           $mt = $montant_total->map(function($item){
               $montant = $item->transacmontant;
               $fraistransaction = $item->fraistransaction;
               $frais = floatval($fraistransaction) * $montant * 1/100;
               $total = $montant - $frais;
               return $total;
           })->sum();
       }

       return $mt;

    }

    public function soldeRetrait($marchand_id){
<<<<<<< HEAD
        
        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->where('marchand_id', '=', $marchand_id)->get();
       
=======

        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->where('marchand_id', '=', $marchand_id)->get();

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
       if ($montant_total->count() == 0 || $montant_total->count() == null) {
           $mt = 0;
       }else {
           $mt = $montant_total->map(function($item){
               $montant = $item->transacmontant;
               $fraistransaction = $item->fraistransaction;
               $frais = floatval($fraistransaction) * $montant * 1/100;
               $total = $montant + $frais;
               return $total;
           })->sum();
       }

       return $mt;

    }


    public function GsoldeTransaction(){

        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','depot')->get();
<<<<<<< HEAD
       
=======

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
       if ($montant_total->count() == 0 || $montant_total->count() == null) {
           $mt = 0;
       }else {
           $mt = $montant_total->map(function($item){
               $montant = $item->transacmontant;
               $fraistransaction = $item->fraistransaction;
               $frais = floatval($fraistransaction) * $montant * 1/100;
               $total = $montant - $frais;
               return $total;
           })->sum();
       }

       return $mt;

    }

    public function GsoldeRetrait(){
<<<<<<< HEAD
        
        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->get();
       
=======

        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->get();

>>>>>>> 9acc1933c4718b29bcba7d306aa94c0660023ac1
       if ($montant_total->count() == 0 || $montant_total->count() == null) {
           $mt = 0;
       }else {
           $mt = $montant_total->map(function($item){
               $montant = $item->transacmontant;
               $fraistransaction = $item->fraistransaction;
               $frais = floatval($fraistransaction) * $montant * 1/100;
               $total = $montant + $frais;
               return $total;
           })->sum();
       }

       return $mt;

    }

}

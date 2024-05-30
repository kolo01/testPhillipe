<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Marchand;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transactions()
    {    
       // $transactions = Transaction::where('id','!=', '')->orderby('created_at','desc')->get();
                // Récupérer les paramètres de recherche depuis la requête
                $periodeDebut = request()->input('periode_debut');
                $periodeFin = request()->input('periode_fin');
                $modepaiement = request()->input('modepaiement');
                $idpaie = request()->input('id_paie');
                $marchand =  Marchand::find(auth()->user()->marchand_id);
                $nom_marchand = $marchand->nom; 
                $marchand_id = $marchand->id; 
                $service_status = $marchand->service_status; 
               
                if ($service_status == 1) {
                    $transactions = DB::connection('mysql2')->table('transactions')->where('marchand_id', auth()->user()->marchand_id);
                    $all_transactions = DB::connection('mysql2')->table('transactions');
                    $infotransaction = DB::connection('mysql2')->table('info_transactions');
                } else {
                    $transactions = Transaction::where('marchand_id', auth()->user()->marchand_id);
                    $all_transactions = Transaction::query();
                    $infotransaction = DB::table('info_transactions');
              
                }

                $query =   auth()->user()->role == 'superAdmin' ?  $all_transactions : $transactions;
                 // Effectuer la recherche
                $transactions = $query
                    ->when($periodeDebut, function ($query) use ($periodeDebut) {
                        return $query->whereDate("created_at",'>=', $periodeDebut);
                    })
                    ->when($periodeFin, function ($query) use ($periodeFin) {
                        return $query->whereDate("created_at",'<=', $periodeFin);
                    })
                    ->when($modepaiement, function ($query) use ($modepaiement) {
                        return $query->where('modepaiement', $modepaiement);
                    })
                    ->when($idpaie, function ($query) use ($idpaie) {
                        
                        return $query->where('merchant_transaction_id',$idpaie);
                    })
                    ->get(); 

           
        return view('transaction.suivi', compact('transactions','nom_marchand','marchand_id'));
    }

    public function detailtransaction($id)
    {    
            $id = base64_decode($id);
            $marchand =  Marchand::find(auth()->user()->marchand_id);
            $nom_marchand = $marchand->nom; 
            $marchand_id = $marchand->id; 
            $service_status = $marchand->service_status; 
            
            if ($service_status == 1) {
    
                $info = DB::connection('mysql2')->table('info_transactions');
                $transactions = DB::connection('mysql2')->table('transactions');
            } else {
                $info = DB::table('info_transactions');
                $transactions = DB::table('transactions');
            
            }
             
            $lesinfos = $info->where('transaction_order_id', $id)->first(); 
            $infotransaction = $transactions->where('merchant_transaction_id', $id)->first(); 
            $infotransaction->montantmarchand = $this->calculFrais($infotransaction->transacmontant, $infotransaction->fraistransaction, $infotransaction->type);
            if ($lesinfos && !empty($lesinfos)) {
                $JsonDecodeprovider = json_decode($lesinfos->provider);
                $provider = json_decode($JsonDecodeprovider);
                $other = json_decode($lesinfos->other_info);
                $lesinfos->nomprenoms = $other[0] ?? "";
                $lesinfos->email = $other[1] ?? "";
                $lesinfos->motif = $other[2] ?? "";
                $lesinfos->nom = $provider->receiver->firstname ?? "";
                $lesinfos->prenoms = $provider->receiver->lastname ?? "";
                $lesinfos->phoneNumber = $provider->receiver->phoneNumber ?? "";
                $lesinfos->parcelUID = $provider->parcelUID ?? ""; 
                $lesinfos->amount = (isset($provider->amount) && !empty($provider->amount)) ? $this->calculFrais($provider->amount, $infotransaction->fraistransaction, $infotransaction->type) : ""; 
            }
            
             $autresinfo = $lesinfos;
         
        return view('transaction.detail', compact('infotransaction','autresinfo','nom_marchand','marchand_id'));
    }


    public function calculFrais($mt, $ft, $tp){
       $mt_retrait = ceil($mt + (($ft/100) * $mt));
       $mt_depot = ceil($mt - (($ft/100) * $mt));
       $mt_recu = $tp == 'retrait' ? $mt_retrait : $mt_depot;
       return  $mt_recu;
    }


    
}

<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Marchand;

trait fondManager
{

    public function soldeCompte(){

         $mt = $this->soldeTransaction(auth()->user()->marchand_id) - $this->soldeRetrait(auth()->user()->marchand_id);

       return $mt;
    }

    public function soldeByCompte($marchand_id){

        $mt = $this->soldeTransaction($marchand_id) - $this->soldeRetrait($marchand_id);

      return $mt;
   }

    public function soldeRetrait___old($marchand_id){
        
        $montant_total = DB::table('retrait_marchands')
                    ->where('status', '=', 'SUCCES')
                    ->where('marchand_id', '=', $marchand_id)
                    ->get();

        if ($montant_total->count() == 0 || $montant_total->count() == null) {
            $mt = 0;
        }else {
            $mt = $montant_total->map(function($item){
                $montant = $item->montant_retrait; 
                return $montant;
            })->sum();
        }
    
        return $mt;

    }

    public function soldeRetrait($marchand_id){
        
        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->where('marchand_id', '=', $marchand_id)->get();
       
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

    public function Retrait($montant_retrait, $user_id, $status, $telephone, $methodpaiement){

        DB::table('retrait_marchands')->insert([
            'telephone' => $telephone,
            'marchand_id' => $user_id,
            'status' => $status,
            'montant_restant' => $this->soldeCompte() - $montant_retrait,
            'montant_retrait' => $montant_retrait,
            'methodpaiement' => $methodpaiement
        ]);

    }


    public function GsoldeRetrait_old(){

        $montant_total = DB::table('retrait_marchands')
                    ->where('status', '=', 'SUCCES')
                    ->get();

        if ($montant_total->count() == 0 || $montant_total->count() == null) {
            $mt = 0;
        }else {
            $mt = $montant_total->map(function($item){
                $montant = $item->montant_retrait; 
                return $montant;
            })->sum();
        }
    
        return $mt;

    }


    public function GsoldeRetrait(){

        $montant_total = Transaction::where('statut', '=', 'SUCCESS')->where('type','retrait')->get();
       
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

    public function GsoldeCompte(){

        $mt = $this->GsoldeTransaction() - $this->GsoldeRetrait();

      return $mt;
   }

    

}



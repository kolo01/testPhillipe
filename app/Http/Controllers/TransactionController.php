<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Marchand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

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
                $statut = request()->input('status');
                $type = request()->input('type');
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
                    ->when($statut, function ($query) use ($statut) {
                        return $query->where('statut', $statut);
                    })
                    ->when($idpaie, function ($query) use ($idpaie) {   
                        return $query->where('merchant_transaction_id',$idpaie);
                    })
                    ->when($type, function ($query) use ($type) {
                        return $query->where('type', $type);
                    })
                    ->orderby('created_at','desc')->get(); 
                  

        return view('transaction.suivi', compact('transactions','nom_marchand','marchand_id'));
    }


    public function SearchTransactions(Request $request)
    {    
       // $transactions = Transaction::where('id','!=', '')->orderby('created_at','desc')->get();
                // Récupérer les paramètres de recherche depuis la requête
                $periodeDebut = request()->input('periode_debut');
                $periodeFin = request()->input('periode_fin');
                $modepaiement = request()->input('modepaiement');
                $idpaie = request()->input('id_paie');
                $statut = request()->input('status');
                $type = request()->input('type');
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
                    ->when($statut, function ($query) use ($statut) {
                        return $query->where('statut', $statut);
                    })
                    ->when($idpaie, function ($query) use ($idpaie) {
                        return $query->where('merchant_transaction_id',$idpaie);
                    })
                    ->when($type, function ($query) use ($type) {
                        return $query->where('type', $type);
                    })
                    ->orderby('created_at','desc')->get(); 
                  

        return view('transaction.suivi', compact('transactions','nom_marchand','marchand_id'));
    }


    public function exportExcel(Request $request)
    {
        // Récupérer les transactions à partir des données JSON envoyées dans la requête
        $transactions = json_decode($request->input('results'), true);
        // Définir le nom du fichier avec l'extension CSV
        $filename = "export_transaction_" . date('Y-m-d_H-i-s') . ".xls";
        // Générer le contenu CSV
        $transactions = (object)$transactions;
        //dd($transactions);
        //$csvContent = View::make('transaction.export', compact('transactions'))->render();
        header("Content-transitaire: application/vnd.ms-excel; charset=iso-8859-1");
        header("Content-disposition: attachment; filename=$filename");
        return view('transaction.export', compact('transactions'));
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

    public checkTransStatus($id){

        try {
            $transaction = Transaction::where('id', $id)->first();
            if ($transaction) {
                Log::info("====TRANSACTION====");
                Log::info($transaction);
                $id = $transaction->notif_token;
                Log::info("Token-ID: ".$id);
                Log::info("NOTIF TOKEN: ".$merchantTransactionId);
                $status = $this->getStatusFromApi($id);
                $decodeRep = $status;
                Log::info("=============CHECK PROBLEM================");
                Log::info($status);
                Log::info("===============END CHECK PROBLEM==============");
                switch ($status) {
                    case 'INITIATED':
                    
                        $statut = 'INITIATED';
                        
                        break;
                    case 'EXPIRED':
                        $statut = 'FAILED';
                        
                        break;
                    case 'SUCCESSFUL':
                    case 'SUCCEED':
                        $statut = 'SUCCESS';
                        break;
                    case 'FAILED':
                    case '404':
                    case 'PENDING':
                        $statut = 'FAILED';
                        
                        break;
                    default:
                        // Gestion d'autres statuts si nécessaire
                        break;
             }  
                Log::info("ID: ".$i++);
                Log::info("STATUS: ".$statut);
                Transaction::where('merchant_transaction_id', $merchantTransactionId)->update(['statut' => $statut]);
                Log::info("====END TRANSACTION====");
            } else {
                Log::info("Transaction not found for merchant_transaction_id: ".$merchantTransactionId);
            }
        } catch (\Throwable $th) {
            Log::info("===============CATCH CHECK PROBLEM==============");
            Log::info($th->getMessage());
            Log::alert("merchant_transaction_id: ".$merchantTransactionId);
            Log::info("===============CATCH END CHECK PROBLEM==============");
        }

    }



public function callbackClientURL($notifToken)
{   
    try {
        Log::info("========================================begin callbackClient===========================");
        Log::info($notifToken);
        $transaction = Transaction::where('notif_token', $notifToken)->first();
        if ($transaction) {
            $marchand_id = $transaction->marchand_id;
            Log::info($marchand_id);
            // Récupération de l'URL de callback du marchand
            $marchand = Marchand::find($marchand_id);
            if ($marchand) {
                $callback_url = $marchand->callback_url;
                // Préparation des données à envoyer
                $requestData = [
                    'code' => 200,
                    'status' => $transaction->statut,
                    'message' => "Your transaction is " . $transaction->statut,
                    'transactionID' => $transaction->merchant_transaction_id
                ];
            } else {
                Log::info("Marchand not found for marchand_id: $marchand_id");
                return; // Marchand non trouvé, ne pas continuer
            }
        } else {
            Log::info("Transaction not found for notif_token: $notifToken");
            return; // Transaction non trouvée, ne pas continuer
        }
        Log::info($requestData);
        // Configuration de cURL
        $curl = curl_init();
        $curlOptions =  [
            CURLOPT_URL => $callback_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ];
        curl_setopt_array($curl, $curlOptions);
        // Exécution de la requête cURL
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // Vérification des erreurs et enregistrement des logs
        if ($err) {
            Log::error("cURL Error: $err");
        } else {
            Log::info("cURL Response: $response");
        }
        Log::info("========================================callbackClient===========================");
    } catch (\Throwable $th) {
        Log::error("Exception occurred: " . $th->getMessage());
    }
}

public function checkIntouchStatus($idTransac, $token) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.bizao.com/mobilemoney/v1/getStatus/'.$idTransac,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
      CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          'country-code: ci',
          'mno-name: mtn',
          'channel: tpe',
          'Content-Type: application/json',
          'Cookie: route=1717602909.798.1111.116589|81ae3a9a04c06b83bdb4bb4311fcd72d'
      ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}


private function getStatusFromApi($id)
{
    $apiUrl = "https://api.gutouch.com/dist/api/touchpayapi/v1/BABIM9924/transaction/{$id}?loginAgent=0778059869&passwordAgent=aqHZcMh69V";
    $authentication = [
        'type' => 'digest',
        'disabled' => false,
        'username' => 'aa4d7ced4d46e0392ca4b747a2594e0df33a94867be8ace9f1fdc35f60bf1ed9',
        'password' => 'da919fc300c3800f4399749a5b21e1a1199a3326d8997e7a07891089abd2871b',
    ];

    $curl = curl_init();
    $curlOptions = [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "User-Agent: insomnia/2023.5.8",
        ],
    ];

    curl_setopt_array($curl, $curlOptions);
    // Ajouter les informations d'authentification digest
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($curl, CURLOPT_USERPWD, "{$authentication['username']}:{$authentication['password']}");
    // Exécutez la requête cURL
    $response = curl_exec($curl);
    $err = curl_error($curl);
    // Fermer la session cURL
    curl_close($curl);

    // Vérifier les erreurs
    if ($err) {
        Log::info("erreur: {$err}");
    } else {
        $result = json_decode($response);
        $status = $result->status;
        Log::info("result : {$response}");
        return $status;
    }
}


public function BizaoCheck($idfromclient) 
{
    try {
        Log::info("=========Bizao IN TRY=================");   
        // Recherche de la transaction
        $rechargement = Transaction::where('notif_token', $idfromclient)->first();
        Log::info("debut rechargement");
        Log::info($rechargement);
        Log::info("rechargement");
        if (!$rechargement) {
            Log::info("Aucune transaction trouvée avec l'ID $idfromclient et le statut 'INITIATED'");
            return;
        }
        $id = "LJCQ5CcRpMeCFzcsQJ9M4w2YDzEa";
        $secret = "EmsVO1BIIZVP_c5bBm7FpeWir8oa";
        $basicAuthorization = base64_encode("$id:$secret");
        $getAccessToken = $this->getAccessToken($basicAuthorization);
        $decodegetAccessToken = json_decode($getAccessToken);
        $access_token = $decodegetAccessToken->access_token;
        $rep = $this->checkTransacStatus($idfromclient, $access_token);
        $decodeRep = json_decode($rep);
        $status = $decodeRep->status;
        $mobile_debite = DB::table('info_transactions')->where('transaction_order_id', $rechargement->merchant_transaction_id)->first()->client_phone ?? "";
        $numero_tel =  Transaction::where('marchand_id', $rechargement->marchand_id)->first()->contact ?? "";
        $nom_marchand = DB::table('marchands')->where('id', $rechargement->marchand_id)->first()->nom ?? "";
        $solde_marchand = $this->soldeMarchandCompte($rechargement->marchand_id); 
        $montant = $rechargement->transacmontant;
        $msg_client = "Paiement reussi! Vers le numero ".$numero_tel." le ".date('d/m/Y à H:i:s').". Montant payé ".number_format($montant,'0', ',', '.')."F chez le marchand ".$nom_marchand;
        $msg_marchand = "Vous avez reçu du numero ".$mobile_debite.". à la date du ".date('d/m/Y à H:i:s')." un montant de ".number_format($rechargement->transacmontant,'0', ',', '.')."F, Frais ".number_format($rechargement->fraistransaction, '0',',','.')."F avec ".$nom_marchand.". Votre nouveau solde est de ".number_format($solde_marchand, '0', ',', '.')."F";
        $cancel_msg_client = "Paiement échoué! vers le numero ".$numero_tel." le ".date('d/m/Y à H:i:s').". Montant ".number_format($montant,'0', ',', '.')."F chez le marchand ".$nom_marchand;
        $cancel_msg_marchand = "Echec de paiement! le numero du payeur est ".$mobile_debite.". Date de paiement ".date('d/m/Y à H:i:s')." Frais ".number_format($rechargement->fraistransaction,'0', ',', '.')."F, Montant ".number_format($rechargement->transacmontant,'0',',','.')."F avec ".$nom_marchand.". Votre solde est de ".number_format($solde_marchand, '0', ',', '.')."F";
        $status = strtoupper($status);
        $token = $rechargement->notif_token;
        Log::info("statut ===> ".$status);
        if (!isset($token)) {
            Log::info("erreur id: Paramètre 'notif_token' manquant dans la requête");
            return;
        }
        
        try {
            switch ($status) {
                case 'INITIATED':
                case 'LOADED': 
                case 'INPROGRESS':
                    $rechargement->statut = 'INITIATED';
                    $statut = 'EN COURS';
                    break;
                case 'CANCELED':
                case 'FAILED':
                    $rechargement->statut = 'FAILED';
                    $statut = 'ECHOUE';
                    break;
                case 'SUCCESSFUL':
                    $rechargement->statut = 'SUCCESS';
                    $statut = 'SUCCES';
                    break;
                default:
                    Log::info("Statut inconnu: $status");
                    return;
            }

            // Enregistrer la transaction mise à jour
            $rechargement->save();
            Log::info("statut ===> ".$status);
            Log::info("type ===> ".$rechargement->type);
        } catch (\Throwable $th) {
            Log::info("=========1- catch BizaoCheck IN INNER TRY=================");
            Log::info('erreur exception: '.$th->getMessage());
            Log::info("ID RECH: ". $rechargement->id." error: ". $th->getMessage().  " REFERENCE OPERATEUR : ". $rechargement->notif_token. " Status : ".$rechargement->statut. " Type transaction : ".$rechargement->modepaiement);
            $rechargement->statut = 'FAILED';
            $rechargement->save();
            Log::info("=========1- catch Fin BizaoCheck IN INNER TRY=================");
        }
    } catch (\Throwable $e) {
        Log::info("=========2- catch BizaoCheck IN INNER TRY=================");
        Log::info("catch===========");
        Log::info($e->getMessage());
        Log::info("=========2- catch Fin BizaoCheck IN INNER TRY=================");
        return $e->getMessage();
        
    }
}


public function getAccessToken($basicAuthorization) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.bizao.com/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic ' . $basicAuthorization,
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


    


    
}


<?php

namespace App\Http\Controllers;

use App\Http\Traits\fondManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marchand;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\SendMailRetrait;
use App\Mail\SendMailInfoRetrait;
use App\Mail\SendMailInfoSuccesRetrait;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;
use App\Models\Depot;
use Illuminate\Support\Facades\Log;


class MarchandController extends Controller
{
    use fondManager;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $marchands = DB::table('marchands')->get();

        $total = $marchands->count();

        $result = $marchands->map(function ($item){
          
                $item->solde = $this->soldeByCompte($item->id);

                return $item;
            });

        return view('marchand.liste-marchand', compact('marchands','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $allCommercial = DB::table('users')->where('role','commercial')->get();
    //   dd($allCommercial);
        return view('marchand.ajouter-marchand', compact('allCommercial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      
        try {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789jhefbiueqjbfwqiubfhiuyf47832urb32yfbe2fy2beufjb23yfb23iufkb2';
            $reference_client = '';
            $charactersLength = strlen($characters);

            for ($i = 0; $i < 7; $i++) {
                $reference_client .= $characters[rand(0, $charactersLength - 1)];
            }

            if ($request->hasFile('dfe') && $request->hasFile('rccm') && $request->hasFile('logo')) {
                $file = $request->file('dfe');

                // Récupérer le nom d'origine du fichier
                $dfe = $file->getClientOriginalName();

                // Déplacer le fichier vers le répertoire de destination
                $file->move(public_path('uploads'), $dfe);

                $getrccm = $request->file('rccm');

                // Récupérer le nom d'origine du fichier
                $rccm = $getrccm->getClientOriginalName();

                // Déplacer le fichier vers le répertoire de destination
                $getrccm->move(public_path('uploads'), $rccm);


                $getlogo = $request->file('logo');

                // Récupérer le nom d'origine du fichier
                $logo = $getlogo->getClientOriginalName();

                // Déplacer le fichier vers le répertoire de destination
                $getlogo->move(public_path('uploads'), $logo);
               
                $marchand = new Marchand();
                $marchand->nom = $request->input('nom');
                $marchand->registrecommerce = $request->input('registrecommerce');
                $marchand->infobusiness = $request->input('infobusiness') ?? null;
                $marchand->contact = $request->input('contact');
                $marchand->dfe = $dfe;
                $marchand->rccm = $rccm;
                $marchand->commercial_id = $request->input('commercial_id');
                $marchand->piece_identite = $logo;
                $marchand->prevision_transac = $request->input('prevision_transac');
                $marchand->tranche_transac = $request->input('tranche_transac');
                $marchand->refercence_cl = $reference_client;
                $marchand->save();

                return back()->with('success', 'Enregistrement effectué avec succès');

            } else {

                return back()->with('error', 'Veuillez joindre les documents');

            }




        } catch (\Exception $err) {
            dd($err);
            // Gestion des erreurs
           // return back()->with('error',  $err->getMessage());
           return back()->with('error', "Erreur d'enregistrement");
        }
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
          $marchand = DB::table('marchands')->where('id', $id)->first();

        return view('marchand.modifier-marchand', compact('marchand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $marchand = Marchand::find($request->input('id'));

            if (!$marchand) {
                return response()->json(['error' => 'Marchand non trouvé'], 404);
            }

        if ($request->hasFile('dfe') && $request->hasFile('rccm') && $request->hasFile('logo')) {

            $file = $request->file('dfe');

            // Récupérer le nom d'origine du fichier
            $dfe = $file->getClientOriginalName();

            // Déplacer le fichier vers le répertoire de destination
            $file->move(public_path('uploads'), $dfe);

            // Retourner une réponse réussie

            $getrccm = $request->file('rccm');

            // Récupérer le nom d'origine du fichier
            $rccm = $getrccm->getClientOriginalName();

            // Déplacer le fichier vers le répertoire de destination
            $getrccm->move(public_path('uploads'), $rccm);

            // Retourner une réponse réussie
            $getlogo = $request->file('logo');

            // Récupérer le nom d'origine du fichier
            $logo = $getlogo->getClientOriginalName();

            // Déplacer le fichier vers le répertoire de destination
            $getlogo->move(public_path('uploads'), $logo);


            $marchand->nom = $request->input('nom');
            $marchand->registrecommerce = $request->input('registrecommerce');
            $marchand->infobusiness = $request->input('infobusiness');
            $marchand->contact = $request->input('contact');
            $marchand->dfe =$dfe;
            $marchand->rccm = $rccm;
            $marchand->piece_identite = $logo;
            $marchand->prevision_transac = $request->input('prevision_transac');
            $marchand->tranche_transac = $request->input('tranche_transac');
            $marchand->save();
            // Retourner une réponse réussie
            return back()->with('success', 'Modification effectuié avec succès');
        } else {
            return back()->with('error', 'Veuillez joindre les document');
        }



        } catch (\Exception $err) {
            // Gestion des erreurs
            return back()->with('error', "Erreur de modification");

        }


        return view('marchand.modifier-marchand', compact('marchand'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       // DB::table('marchands')->where('id', $id)->delete();

        return back();
    }

    public function TransfertMoney($id)
    {
        return back()->with('error', 'Le serveur est indisponible, veuillez réessayer plus tard.');
        $request = DB::table('retrait_marchands')->where('id', $id)->first();
        $op = $request->methodpaiement;
        $montant = $request->montant_retrait;
        $telephone = $request->telephone;
        $solde = $this->soldeByCompte($request->marchand_id);
        $status = 'SUCCES';
        $request->confirm_montant = $montant;

        $frais = ($montant * (2/100));
        $nom_marchand = Marchand::find($request->marchand_id)->nom;
        $emailArray = User::where('marchand_id',$request->marchand_id)->select('email')->get();
        $new_montant = $montant - $frais;
        $array_marchand = [
            'montant' =>$new_montant,
            'frais' => $frais,
            'nom_marchand' => $nom_marchand,
            'status' =>$status,
            'telephone' => $telephone,
        ];

        if ($montant <= 499) {
            return back()->with('error', 'Le montant minimum de transfert est de 500 fcfa.');
         }
         //return response()->json('ok');

         //Solde insuffisant
        if ($montant > $solde) {
            $status = 'ECHOUE';
            return back()->with('error', 'Désolé le solde du marchand est insuffisant.');
        }
        //dd($op);
        if ($op == 'OM_CI') {
            return back()->with('error', 'Le serveur est indisponible, veuillez réessayer plus tard.');
        } elseif ($op == 'WAVE_CI') {
          // Vérifier si le numéro de téléphone contient exactement dix chiffres
            if (strlen($telephone) === 10 && ctype_digit($telephone) && ($montant == $request->confirm_montant)) {
                // Le numéro de téléphone est valide
                $idem_key = uniqid($prefix = "RET-");
                $curl = curl_init();
                // 65f735b4-b44b-429d-b0a8-550701e2393a',
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.wave.com/v1/payout',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "currency": "XOF",
                    "receive_amount": "'.$new_montant.'",
                    "mobile": "+225'.$telephone.'"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'idempotency-key:'.$idem_key,
                        'Authorization: Bearer wave_ci_prod_Gw8_mBMNC0CUK-F1TGqWauowuFv8KqUkORNP2N5un3vWiiyESpO16cVvWdwFkIBxL9SJv5Klt5z7zzyFZpRQp8dxx3PyIvQV7g'
                    ),

                ));

                $response = curl_exec($curl);

                curl_close($curl);

                try {
                    $rep = json_decode($response);
                    $result = $rep->status;
                    $status = 'SUCCES';
                    if ($result == "succeeded") {
                        DB::table('retrait_marchands')->where('id', $id)->update(['status' => 'SUCCES']);
                        $marchand = (object)$array_marchand;
                        foreach ($emailArray as $email) {
                            Mail::to($email->email)->send(new SendMailInfoSuccesRetrait($marchand));
                        }
                        return back()->with('success', 'Demande validée, transfert effectué avec succès');
                    } else {
                        return back()->with('error', 'Solde insuffisant dans le wallet');
                    }
                }catch (\Exception $e){
                    return back()->with('error', 'Solde insuffisant dans le wallet');
                }
            } else {
                // Le numéro de téléphone n'est pas valide
                return response()->json(2);
            }

        } elseif ($op == 'MOOV_CI'){
            return back()->with('error', 'Le serveur est indisponible, veuillez réessayer plus tard.');
        } elseif ($op == 'MOMO_CI') {
             // Vérifier si le numéro de téléphone contient exactement dix chiffres
            if (strlen($telephone) === 10 && ctype_digit($telephone) && ($montant == $request->confirm_montant)) {
                //dd("momo ");
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://proxy.momoapi.mtn.com/disbursement/token/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Length: 0',
                        'X-Target-Environment' => 'mtnivorycoast',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Ocp-Apim-Subscription-Key:7d65505d884040d482bac9f17f415b5d',
                        'Authorization:Basic Mjk3ZDhiZGQtZjQxNS00MzU3LTk0NWEtYjEyNjhjZGZiYmE0OmY5ZDczNTk3OTA3NTQ5OTdiM2M5M2EwYWZlYTBlZWRi'
                    ),
                ));

                //Mjk3ZDhiZGQtZjQxNS00MzU3LTk0NWEtYjEyNjhjZGZiYmE0OmY5ZDczNTk3OTA3NTQ5OTdiM2M5M2EwYWZlYTBlZWRi | API_KEY + API_USER
                $curl_exec = curl_exec($curl);

                $response = json_decode($curl_exec);
                $error = curl_error($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $globalhttp = $httpcode;
                curl_close($curl);

                if ($error) {
                    return response()->json(['status'=>500, 'message' => "Un problème est survenu ".$error]);
                }elseif($response){

                    $curl_b = curl_init();
                    $config_b = [
                        CURLOPT_URL => 'https://proxy.momoapi.mtn.com/disbursement/v1_0/account/balance',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Length: 0',
                            'Ocp-Apim-Subscription-Key: 7d65505d884040d482bac9f17f415b5d',
                            'X-Target-Environment: mtnivorycoast',
                            'Authorization: Bearer ' .$response->access_token,
                            'Content-Type: application/json'
                            //'Content-Type' => 'application/x-www-form-urlencoded',
                        ),
                    ];

                    $ch_b = curl_init();
                    curl_setopt_array($ch_b, $config_b);
                    $checkbalance = curl_exec($ch_b);
                    $balance = json_decode($checkbalance);
                    $error_b = curl_error($ch_b);
                    $httpcode_b = curl_getinfo($curl_b, CURLINFO_HTTP_CODE);
                    curl_close($curl_b);
                    $availableBalance = $balance->availableBalance;




                    try{

                        $access_token = $response->access_token;
                       // return "succeeded";
                        if(isset($access_token)){

                            $curl = curl_init();

                            $uuid = Str::random(4);
                           // $montant = "100";
                            $json = '{
                            "amount": "' . $new_montant . '",
                            "currency": "XOF",
                            "externalId": "' . $uuid . '",
                            "payee": {
                                "partyIdType": "MSISDN",
                                "partyId": "' . '225'.$telephone . '"
                            },
                            "payerMessage": "Vous transférer de l\'argent de votre compte Babimo",
                            "payeeNote": "tests"
                            }';

                            $config = [
                                CURLOPT_URL => 'https://proxy.momoapi.mtn.com/disbursement/v1_0/transfer',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => $json,
                                CURLOPT_HTTPHEADER => array(
                                    'Ocp-Apim-Subscription-Key: 7d65505d884040d482bac9f17f415b5d',
                                    'X-Reference-Id: ' . $uuid,
                                    'X-Target-Environment: mtnivorycoast',
                                    'Authorization: Bearer ' .$access_token,
                                    'Content-Type: application/json'
                                ),
                            ];

                            $ch = curl_init();
                            curl_setopt_array($ch, $config);
                            $response = curl_exec($ch);
                            $rep_payment = json_decode($response);
                            $error = curl_error($ch);
                            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            curl_close($curl);

                            if ($error) {
                                return response()->json(['status'=>400, 'message' => "Un problème est survenu ".$error]);
                            }else{

                                if ($httpcode == '201' || $httpcode == '200') {
                                    $status = 'SUCCES';
                                   // dd("httpcode = ".$httpcode, $error, "status ==>", $montant, auth()->user()->marchand_id, $status,  $telephone, $rep_payment);
                                     //$this->Retrait($montant, auth()->user()->marchand_id, $status,  $telephone);
                                     DB::table('retrait_marchands')->where('id', $id)->update(['status' => 'SUCCES']);
                                    $rep = "succeeded";
                                    $marchand = (object)$array_marchand;
                                    foreach ($emailArray as $email) {
                                        Mail::to($email->email)->send(new SendMailInfoSuccesRetrait($marchand));
                                    }
                                    return back()->with('success', 'Demande validée, transfert effectuié avec succès');
                                } else {
                                   // dd("dddddddsss");
                                    $data = ["status" => 500, "message" => 'Impossible d\effectuer le transfert'];
                                    return back()->with('error', 'Impossible d\'effectuer le transfert');
                                }

                            }
                        }

                    } catch (\Exception $err) {
                        $data = ["status" => 500, "message" => 'Erreur du serveur '.$err];
                        return response()->json($data);
                    }
                }

            } else {
                #Le numéro de téléphone n'est pas valide
                return back()->with('error', 'Impossible d\'effectuer le transfert, veuillez vérifier le numero de telephone et le montant.');
            }

        } else {
            return back()->with('error', 'Le serveur est indisponible, veuillez réessayer plus tard.');
        }


    }

    public function ManageTransactionMarchand()
    {

         if(auth()->user()->role == 'superAdmin'){
            $solde = $this->GsoldeCompte();
            $reference_client = DB::table('marchands')->where('id', auth()->user()->marchand_id)->first()->refercence_cl;
            $link = 'https://account-marchand.babimo.com/collect/?type='.base64_encode($reference_client);
            $retraits = DB::table('retrait_marchands')->orderby('created_at','desc')->get();
         }else {
            $solde = $this->soldeCompte();
            $reference_client = DB::table('marchands')->where('id', auth()->user()->marchand_id)->first()->refercence_cl;
            $link = 'https://account-marchand.babimo.com/collect/?type='.base64_encode($reference_client);
            $retraits = DB::table('retrait_marchands')->where('marchand_id', '=', auth()->user()->marchand_id)->orderby('created_at','desc')->get();
         }

        return view('marchand.soldeManager', ['solde' => $solde, 'retraits' => $retraits, "link" => $link]);
    }

    public function active($id)
    {
        $q = DB::table('marchands')->where('id', $id);
        $marchands = $q->first();
        $service_status = $marchands->service_status;
        DB::table('marchands')->where('id', $id)->update([
            'service_status' => !$service_status
        ]);
        $nq = DB::table('marchands')->where('id', $id);
        $msg = $nq->first()->service_status == 1 ? "est désormais en mode test" : "est désormais en mode production";

        return back()->with('success', 'Le marchand '.$marchands->nom.' '.$msg);
    }


    public function DemandeRetrait(Request $request)
    {


        $op = $request->operator;
        $montant = $request->montant;
        $confirm_montant = $request->confirm_montant;
        $telephone = $request->telephone;
        $solde = $this->soldeCompte();
        $status = 'EN COURS';
        $email = auth()->user()->email;
        $emailArray = User::where('role', 'superAdmin')->select('email')->get();
        $getmarchand =  Marchand::find(auth()->user()->marchand_id);
        $nom_marchand = $getmarchand->nom;
        $tranch_retrait = $getmarchand->tranche_retrait;
        $retrait = DB::table('retrait_marchands')->where('marchand_id', auth()->user()->marchand_id);
        $checking = $retrait->where('status', $status)->exists();
        $frais = ($request->montant * ($tranch_retrait/100));
        $new_montant = $montant + $frais;
        $merchant_transaction_id = strtoupper(uniqid("Ret-"));

        $array_marchand = [
            'montant' =>$new_montant,
            'frais' => $frais,
            'nom_marchand' => $nom_marchand,
            'status' =>$status,
            'telephone' => $telephone,
        ];


        $transaction_data = [
            "transacmontant" => strval($montant),
            "modepaiement" => $request->operator,
            "fraistransaction" => $tranch_retrait,
            "marchand_id" => auth()->user()->marchand_id,
            "merchant_transaction_id" => $merchant_transaction_id,
            "id_initiate_transaction" => $this->generateNumber(),
            "notif_token" => $this->generateTransactionId(),
            "statut" => "INITIATED",
            "type" => "retrait"
        ];

        $data = [
            'montant_retrait' =>  $montant,
            'marchand_id' =>  auth()->user()->marchand_id,
            'status' => 'EN COURS',
            'telephone' => $telephone,
            'methodpaiement' => $op,
            'notif_token' => $transaction_data['notif_token'],
            'montant_restant' => $solde - $new_montant
        ];


        $marchand = (object)$array_marchand;

        if ($checking) { return response()->json('retraitEnCours'); }

        if ($montant <= 499) { return response()->json('minimum'); }
         //Solde insuffisant
        if ($new_montant > $solde) {
            return response()->json('lowbalance');
        }else{

            $transaction = Transaction::create($transaction_data);
            //$retrait =  RetraitMarchand::create($data);
            $retrait = $this->Retrait($data);

            try {
                // Vérifier si le numéro de téléphone contient exactement dix chiffres
                if (strlen($telephone) === 10 && ctype_digit($telephone) && $montant == $confirm_montant) {
                    // Le numéro de téléphone est valide
                    $cashin = [
                        "payment_method" => $request->operator,
                        "recipient_phone_number" => $telephone,
                        "amount" => $montant,
                        "notif_token" => $transaction_data['notif_token']
                    ];

                    $cashin_result = $this->cashin($cashin);
                    $response = $result['response'];
                    $err = $result['err'];
                    //dd($err);
                    if ($err) {
                        DB::table('retrait_marchands')->where('id', $retrait->id)->update(['status' => 'ECHOUE']);
                        Transaction::where('id', $transaction->id)->update(['status' => 'FAILED']);
                        Log::info("error transfert api:".$err);
                        $result = Array (
                            'message' => 'Transfert has failed',
                            'code' => 300,
                            'status' => 'FAILED'
                        );
                        return $result;
                    } else {
                        $response = json_decode($response);
                        $response = (object)$response;
                        switch ($response->status) {
                            case 'INITIATED':
                            case 'PENDING':
                                $status = 'EN COURS';
                                break;
                            case 'EXPIRED':
                                $status = 'ECHOUE';
                                break;
                            case 'SUCCESSFUL':
                            case 'SUCCEED':
                                $status = 'SUCCES';
                                break;
                            case 'FAILED':
                                $status = 'ECHOUE';
                                break;
                            default:
                                break;
                        }
                        DB::table('retrait_marchands')->where('id', $retrait->id)->update(['status' => $status]);
                        return response()->json('succeeded');

                    }
                } elseif($montant != $confirm_montant) {
                    return response()->json('failed');
                } elseif(!ctype_digit($telephone)) {
                    return response()->json('isNotNumber');
                } elseif(strlen($telephone) !== 10) {
                    return response()->json('isNotEqualTo');
                }else{
                    return response()->json('failed');
                }

            } catch(\Exception $e){
                DB::table('retrait_marchands')->where('id', $retrait->id)->update(['status' => $status]);
                Transaction::where('id', $transaction->id)->update(['status' => 'FAILED']);
                return response()->json('error: ' . $e->getMessage());
            }

        }

    }

    public function NewsoldeCompte($marchand_id){

        $mt = $this->soldeTransaction($marchand_id) - $this->soldeRetrait($marchand_id);

      return $mt;
   }

   public function CancelTransfertMoney($id)
   {
       DB::table('retrait_marchands')->where('id', $id)->update(['status' => 'ECHOUE']);
       return back()->with('success', 'Demande de transfert annulé avec succès');
   }


#-----------------------------Cashin API----------------------------------
   private function generateNumber()
   {
       $chaineNumerique = "123456789";
       $chiffres = str_split($chaineNumerique);
       shuffle($chiffres);
       $chaineNumeriqueMelangee = implode("", $chiffres);
       return $chaineNumeriqueMelangee;

   }

   private function generateTransactionId()
   {
       $chaineNumerique = "15487171111113669728";
       $chiffres = str_split($chaineNumerique);
       shuffle($chiffres);
       $chaineNumeriqueMelangee = implode("", $chiffres);
       return $chaineNumeriqueMelangee;


   }

   public function cashin($request)
   {
      $request = (object)$request;
      switch ($request->payment_method) {
        case 'OM_CI':
            $service_id = 'CASHINOMCIPART';
            break;
        case 'WAVE_CI':
            $service_id = 'CI_CASHIN_WAVE_PART';
            break;
        case 'MOOV_CI':
            $service_id = 'CASHINMOOVPART';
            break;
        case 'MTN_CI':
            $service_id = 'CASHINMTNPART';
            break;
        default:
            break;
      }

       $requestData = [
           "service_id" => $service_id,
           "recipient_phone_number" => $request->recipient_phone_number,
           "amount" => $request->amount,
           "partner_id" => "CI29681",
           "partner_transaction_id" => $request->notif_token,
           "login_api" => "0778059869",
           "password_api" => "aqHZcMh69V",
           "call_back_url" => "https://b-pay.co/api/v1/babimo/callback",
       ];

       $curl = curl_init();
       $curlOptions =  [
           CURLOPT_URL => "https://apidist.gutouch.net/apidist/sec/BABIM9924/cashin",
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => "",
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 30,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS => json_encode($requestData),
           CURLOPT_HTTPHEADER => [
               "Authorization: Basic YWE0ZDdjZWQ0ZDQ2ZTAzOTJjYTRiNzQ3YTI1OTRlMGRmMzNhOTQ4NjdiZThhY2U5ZjFmZGMzNWY2MGJmMWVkOTpkYTkxOWZjMzAwYzM4MDBmNDM5OTc0OWE1YjIxZTFhMTE5OWEzMzI2ZDg5OTdlN2EwNzg5MTA4OWFiZDI4NzFi",
               "Content-Type: application/json"
             ],
       ];
       curl_setopt_array($curl, $curlOptions);
       //Execute cURL request
       $response = curl_exec($curl);
       $err = curl_error($curl);
       //Close cURL session
       curl_close($curl);
       return ['response'=>$response, 'err'=>$err];
   }
#-----------------------------END-------------------------------------

#-----------------------------DEPOT-------------------------------------

public function depot()
{
     if(auth()->user()->role == 'superAdmin'){
        $reference_client = DB::table('marchands')->where('id', auth()->user()->marchand_id)->first()->refercence_cl;
        $depots = DB::table('depots')->orderby('created_at','desc')->get();
     }else {
        $reference_client = DB::table('marchands')->where('id', auth()->user()->marchand_id)->first()->refercence_cl;
        $depots = DB::table('depots')->where('marchand_id', '=', auth()->user()->marchand_id)->orderby('created_at','desc')->get();
     }
    return view('marchand.depot', ['depots' => $depots]);
}

public function storeDepot(Request $request)
{
    $amountWithoutSeparator = str_replace(' ', '', $request->montant);
    try{
        $depot = new Depot;
        $depot->montant_depot = $amountWithoutSeparator;
        $depot->marchand_id = auth()->user()->marchand_id;
        $depot->payment_file = $request->payment_file;
        $depot->save();
        $marchand = Marchand::find($depot->marchand_id)->nom;
        try {
            // Récupérez le fichier à partir de la requête
            $file = request()->file('payment_file');
            // Vérifiez si le fichier est valide
            if ($file) {
                $fileName = $marchand.'_'.uniqid($marchand) . '.' . $file->getClientOriginalExtension();
                //$file->move(public_path('depotbanque'), $fileName);
                $file->move('depotbanque', $fileName);
                $depot->payment_file = $fileName;
                $depot->save();
                return "succeeded";
            } else {
                return "failed";
            }
        } catch (\Throwable $th) {
            Log::info("Erreur: ".$th->getMessage());
            return $th->getMessage();
        }

        if($store){
            return response()->json('succeeded');
        } elseif($montant != $confirm_montant) {
            return response()->json('failed');
        } elseif(!ctype_digit($telephone)) {
            return response()->json('isNotNumber');
        }else{
            return response()->json('failed');
        }
        Log::info("depot effectué");
    } catch(\Exception $e){
        Log::info("erreur d'enregsitrment des information du depot ". $e->getMessage());
       return response()->json('error: ' . $e->getMessage());
    }

}

public function validDepotMoney($depotId)
{
    $request = Depot::find($depotId);
    $getmarchand =  Marchand::find($request->marchand_id);
    $nom_marchand = $getmarchand->nom;
    $tranche_transac = '0';
    $amountWithoutSeparator = $request->montant_depot;
    $frais = ($amountWithoutSeparator * ($tranche_transac/100));
    $transaction_data = [
        "transacmontant" => strval($request->montant_depot),
        "modepaiement" => 'DEP',
        "fraistransaction" => $tranche_transac,
        "marchand_id" => $request->marchand_id,
        "merchant_transaction_id" => $this->generateNumber(),
        "id_initiate_transaction" => $this->generateNumber(),
        "notif_token" => $this->generateTransactionId(),
        "statut" => "SUCCESS",
        "type" => "depot"
    ];
    try {
        // Mettez à jour le statut du dépôt à "Validé"
        DB::table('depots')->where('id', $depotId)->update(['status' => 'SUCCESS']);
        $store = Transaction::create($transaction_data);
        DB::table('depots')->where('id', $depotId)->update(['transaction_id' => $store->id]);
        return back();
    } catch (\Throwable $th) {
        Log::error("Erreur lors de la validation du dépôt: ".$th->getMessage());
        throw $th;
    }
}

public function cancelDepotMoney($depotId)
{
    try {
        // Mettez à jour le statut du dépôt à "Annulé"
        $depot = DB::table('depots')->where('id', $depotId);
        $depot->update(['status' => 'FAILED']);
        Transaction::where('id', $depot->first()->transaction_id)->update(['statut' => 'FAILED']);
        return back();
    } catch (\Throwable $th) {
        Log::error("Erreur lors de l'annulation du dépôt: ".$th->getMessage());
        return $th->getMessage();
    }
}

#-----------------------------DEPOT-------------------------------------

#-----------------------------RETRAIT------------------------------------- //a déploeyr
public function Retrait($data){

    $retrait = RetraitMarchand::create($data);

    return $retrait;

}
#-------------------------------------FIN RETRAIT-------------------------------------
}

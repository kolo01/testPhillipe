<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Traits\sendSMS;
use App\Mail\RetraitRib;
use App\Mail\RetraitRibValidate;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Models\Marchand;
use Datetime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CompteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  use sendSMS;

  public function changePassword()
  {
    return view('compte.change-password');
  }


  public function profil()
  {
    $user = auth('web')->user();
    $marchand = DB::table("marchands")->find(auth()->user()->marchand_id);
    // dd($marchand);
    return view('compte.profil', compact('user', "marchand"));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function updatePassword(Request $request)
  {
    // Valider les données du formulaire
    $request->validate([
      'current_password' => 'required',
      'new_password' => 'required|min:8',
      'confirm_password' => 'required|same:new_password',
    ]);

    // Obtenir l'utilisateur authentifié
    $getuser = auth('web')->user();

    // Vérifier si le mot de passe actuel correspond
    if (!Hash::check($request->current_password, $getuser->password)) {
      return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
    }

    // Mettre à jour le mot de passe de l'utilisateur
    $user = User::find($request->user_id);
    $user->code = $request->new_password;
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Le mot de passe a été modifié avec succès.');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function sms()
  {
    $sms = $this->getSmsOtp();
    $totalSms = $sms[0]->availableUnits;
    return $totalSms;
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
  //======================check transaction================
  public function checkTheTransaction()
  {
    // $donnees = [
    //     "RET172050447911884277",
    //     "RET172050449350143614",
    //     "RET172050449781198745",
    //     "RET172050448910760409",
    //     "RET172050449906496623",
    //     "RET172050449843588605",
    //     "RET172050448474280378",
    //     "RET172050448098424799",
    //     "RET172050448538824495",
    //     "RET172050449038516606",
    //     "RET172050448979290059",
    //     "RET172050447972806656",
    //     "RET172050448037260624",
    //     "RET172050448283139733",
    //     "RET172050448221329348",
    //     "RET172050447852629622"
    // ];
    // $donnees = array(
    //     "RET172077053263473790",
    //     "RET172077053203878786",
    //     "RET172077053144091892",
    //     "RET172077053082365388",
    //     "RET172077053022980313",
    //     "RET172077025050925623"
    // );

    // $donnees = [
    //     "RET172077250052295854",
    //     "RET172077053979282206",
    //     "RET172077053861445624",
    //     "RET172077053321898289",
    //     "RET172077053263473790",
    //     "RET172077053203878786",
    //     "RET172077053144091892",
    //     "RET172077053082365388",
    //     "RET172077053022980313",
    //     "RET172077035963367032",
    //     "RET172077033984250327",
    //     "RET172077025050925623",
    //     "RET172077022970096520",
    //     "RET172076782354857808",
    //     "RET172076782305830778",
    //     "RET172076782256641202",
    //     "RET172076782206252690",
    //     "RET172076782158357747",
    //     "RET172076782110003043",
    //     "RET172076782062196939",
    //     "RET172076782013544479",
    //     "RET172076781937520501",
    //     "RET172076777859967187",
    //     "RET172076584172194116",
    //     "RET172076584121302930",
    //     "RET172076584072399402",
    //     "RET172076584021616216",
    //     "RET172076583970739496",
    //     "RET172076583920158961",
    //     "RET172076583870803173",
    //     "RET172076458252826567",
    //     "RET172076458191612763",
    //     "RET172076458132068485",
    //     "RET172076458064481308",
    //     "RET172076457943264352",
    //     "RET172076457885302076",
    //     "RET172076457824441040",
    //     "RET172076421907588817",
    //     "RET172076375047735943",
    //     "RET172076331987837884",
    //     "RET172074636964201503"
    // ];
    $donnees = Transaction::where('created_at', '>=', '2024-07-01')
      ->whereIn('statut', ['FAILED', 'INITIATED'])
      ->where('type', 'retrait')
      ->pluck('merchant_transaction_id');

    // Identifiants pour générer le Basic Token
    $id = "LJCQ5CcRpMeCFzcsQJ9M4w2YDzEa";
    $secret = "EmsVO1BIIZVP_c5bBm7FpeWir8oa";
    $basicAuthorization = base64_encode("$id:$secret");
    // Obtenir le jeton d'accès (access_token) en utilisant le Basic Token
    $getAccessToken = $this->getAccessToken($basicAuthorization);
    $decodegetAccessToken = json_decode($getAccessToken);
    $access_token = $decodegetAccessToken->access_token;
    set_time_limit(0);
    $i = 1;
    foreach ($donnees as $merchantTransactionId) {
      try {
        $transaction = Transaction::where('merchant_transaction_id', $merchantTransactionId)->first();
        if ($transaction) {
          Log::info("====TRANSACTION====");
          Log::info($transaction);
          $id = $transaction->notif_token;
          Log::info("Token-ID: " . $id);
          Log::info("NOTIF TOKEN: " . $merchantTransactionId);

          //$rep = $this->checkTransacStatus($id, $access_token);
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
          Log::info("ID: " . $i++);
          Log::info("STATUS: " . $statut);
          Transaction::where('merchant_transaction_id', $merchantTransactionId)->update(['statut' => $statut]);
          Log::info("====END TRANSACTION====");
          $this->callbackClientURL($id);
        } else {
          Log::info("Transaction not found for merchant_transaction_id: " . $merchantTransactionId);
        }
      } catch (\Throwable $th) {
        Log::info("===============CATCH CHECK PROBLEM==============");
        Log::info($th->getMessage());
        Log::alert("merchant_transaction_id: " . $merchantTransactionId);
        Log::info("===============CATCH END CHECK PROBLEM==============");
      }
    }
    set_time_limit(120);
  }

  public function getAccessToken($basicAuthorization)
  {
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

  public function checkTransacStatus($idTransac, $token)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.bizao.com/mobilemoney/v1/getStatus/' . $idTransac,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
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

  // Méthode pour obtenir le statut depuis l'API
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
  //======================end check transaction================

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


  ////By me


  public function updateRib(Request $request)
  {
    // dd($request);
    // Valider les données du formulaire
    $request->validate([
      'rib' => 'required|max:255',
    ]);
    // Mettre à jour le RIB de l'utilisateur


    $marchand = Marchand::find(auth()->user()->marchand_id);
    // dd($marchand);
    $marchand->rib = $request->rib;
    // dd("marchand", $marchand);
    $marchand->update($request->all());

    return redirect()->back()->with('success', 'Le RIB a été modifié avec succès.');
  }

  public function indexRib()
  {
    // Récupérer le RIB de l'utilisateur
    $user = auth()->user();
    $allTransacation = DB::table('retrait_ribs')->get();
    //  JSONencode(user firts& last & numero& mail)  "a mettre dans trace"

    $marchand = Marchand::find(auth()->user()->marchand_id);
    // dd($marchand);
    return view('marchand.retrait-rib', compact('marchand', "user", "allTransacation"));
  }


  public function saveRetrait(Request $request)
  {
    $request->validate([
      'amount' => 'required|max:10',
    ]);
    $email = "konedieu5@gmail.com";
    // Sauvegarder le retrait
    $encodedData = array();
    array_push($encodedData, auth()->user()->username);
    array_push($encodedData, auth()->user()->telephone);
    array_push($encodedData, auth()->user()->email);

    // dd(json_encode($encodedData));
    // creation de la requete

    $data = [
      'marchand_id' => auth()->user()->marchand_id,
      'trace' => json_encode($encodedData),
      'amount' => $request->amount,
      'createdAt' => now(),
      'updatedAt' => now(),
    ];

    $id = DB::table('retrait_ribs')->insertGetId($data);

    // debut de la recuperation
    $allSuperAdmin = DB::table('users')->where('role', 'superAdmin')->get()->all();


    for ($i = 0; $i < count($allSuperAdmin); ++$i) {

      Mail::to( $allSuperAdmin[$i]->email)->send(new RetraitRib(auth()->user()->username, $request->amount, auth()->user()->telephone));
    }
    // foreach ($allSuperAdmin as $key => $value) {
    //   dd($value);
    //
    // }

    return redirect()->back()->with('success', 'Le RIB a été modifié avec succès.');
  }


  public function acceptPaiement($index)
  {
    // Accepter le paiement
    $allInfo =  DB::table('retrait_ribs')
      ->where('id', $index)
      ->update([
        'status' => "SUCCES",
        'updatedAt' => now(),
      ]);
    // dd($allInfo);
    $request = DB::table('retrait_ribs')
      ->where('id', $index)
      ->first();
    // $email = $request->trace;

    $encodedData = json_decode($request->trace);

    // dd($encodedData);


    // $id = DB::table('retrait_ribs')->insertGetId($data);

    Mail::to($encodedData[2])->send(new RetraitRibValidate($encodedData[0], $request->amount, $encodedData[1]));
    return redirect()->route('marchand.ribindex')->with('success', 'Paiement accepté avec succès.');
  }


  public function cancelPaiement($index)
  {
    $allInfo =  DB::table('retrait_ribs')
      ->where('id', $index)
      ->update([
        'status' => "ECHOUE",
        'updatedAt' => now(),
      ]);
    // dd($allInfo);
    return redirect()->route('marchand.ribindex')->with('success', 'Paiement accepté avec succès.');
  }
}

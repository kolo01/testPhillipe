<?php
namespace App\Http\Traits\Orange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


trait Transaction_op {

    protected function Transaction_op($body)
    {


        try {

            $resp = [];


               $opera_initiated = DB::table('initiate_transactions')->where('link_token', $body->token_nofif)->first();

               if($opera_initiated){
               //$body->payment_method = 'OM_CI';
               if ($opera_initiated->payment_method == "OM_CI") {
                // TODO: this is a credential takinq of orange API

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.orange.com/oauth/v3/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic aGdHQ3NjdXJaNzRGRmhFN0ZGWE9YaDVHODkxckxYWkE6VUF3R01YbVEwNzNzQmhWMw==',
                        'Content-Type: application/x-www-form-urlencoded'
                    ),
                ));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $response = json_decode(curl_exec($curl));

                $error = curl_error($curl);

                if ($error) {

                   return $error;

                }elseif ($response) {

                    $rep_token = $response->access_token;

                    if (isset($rep_token)) {

                        $order_id = Str::random(70);
                        //$opera_initiated
                        // $success_url = route('successURL', $opera_initiated->link_token);
                        // $failed_url = route('failedURL', $opera_initiated->link_token);
                        // $notify_url = route('notifiedURL', $opera_initiated->link_token);
                         $success_url="https://8cbbcb8d08d6.ngrok.io";
                         $failed_url = "https://8cbbcb8d08d6.ngrok.io";
                         $notify_url = "https://8cbbcb8d08d6.ngrok.io";
                        $accessToken = $rep_token;

                        $data = json_encode([
                            "merchant_key" => "98d8a79e",
                            "currency" => $opera_initiated->currency,
                            "order_id" => $opera_initiated->link_token,
                            "amount" => $opera_initiated->amount,
                            "return_url" => $success_url,
                            "cancel_url" => $failed_url,
                            "notif_url" => $notify_url,
                            "lang" => "fr",
                            "reference" => $opera_initiated->refercence_cl
                        ]);

                        $config = [
                            CURLOPT_POST => 1,
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => 'https://api.orange.com/orange-money-webpay/ci/v1/webpayment',
                            CURLOPT_HTTPHEADER => [
                                'Authorization: Bearer ' . $accessToken,
                                'Content-Type: application/json'
                            ],
                            CURLOPT_POSTFIELDS => $data
                        ];

                        $ch = curl_init();
                        curl_setopt_array($ch, $config);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        $response = curl_exec($ch);
                        $rep_payment = json_decode($response);
                        $error = curl_error($ch);

                         if ($error) {
                            return response()->json(['status'=>400, 'message' => "Un problème est survenu ".$error]);
                         }
                         //return response()->json(['status'=>400, 'message' => $rep_payment]);

                        if ($rep_payment) {
                            $marchand = DB::table('marchands')->where('refercence_cl', $body->refercence_cl)->first();
                            try {
                                // var_dump($rep_payment);
                                // die();
                                $transdata = DB::table('transactions')->insert([
                                    "transacmontant" => strval($opera_initiated->amount),
                                    "modepaiement" => $opera_initiated->payment_method,
                                    "fraistransaction" => intval($marchand->tranche_transac),
                                    "marchand_id" => $marchand->id,
                                    "merchant_transaction_id" =>$opera_initiated->merchant_transaction_id,
                                    "id_initiate_transaction" => $opera_initiated->id,
                                    "notif_token" => $rep_payment->pay_token,
                                    "statut" => "INITIATED"
                                ]);

                                $data = [
                                    "pay_token" => $rep_payment->pay_token,
                                    "payment_url" => $rep_payment->payment_url
                                ];
                                return response()->json(['status' => 201, 'data'=>$data]);
                            } catch (\Exception $e) {
                                $resp = $e;
                                return response()->json(['status'=>400, 'message' => "error: " . $e->getMessage()]);
                            }
                        }
                    }
                }

               }
               }else{
                return response()->json(['status'=>500, 'message' => "error: " . "Transaction not found"]);
               }
        } catch (\Exception $err) {
            $data = ["status" => 500, "message" => 'Erreur du serveur '.$err];
            return response()->json($data);
        }
    }


}

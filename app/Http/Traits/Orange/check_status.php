<?php
namespace App\Http\Traits\Orange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait check_status {

    protected function Check_status($body)
    {
      
    
        $data = json_encode([
            "pay_token" => $body->pay_token,
            "amount" => $body->amount,
            "order_id" => $body->order_id
        ]);

        $config = [
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.orange.com/orange-money-webpay/ci/v1/transactionstatus',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $body->accessToken,
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => $data
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $config);
        $response = curl_exec($ch);
        $rep_status = json_decode($response);
        
            if ($rep_status->status =="INITIATED") {
                # code...
            } elseif ($rep_status->status =="FAILED") {
                DB::table('transactions')->where('id', $body->order_id)->update(["statut" => $rep_status->status]);
            } else {
                DB::table('transactions')->where('id', $body->order_id)->update(["statut" => 'VALIDED']);
            }
        
       return response()->json(201);

    }


}
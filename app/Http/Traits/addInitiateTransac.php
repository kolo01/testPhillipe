<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Operateur;

trait addInitiateTransac
{
    public function addInitiateTransac($request)
    {
        try {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789jhefbiueqjbfwqiubfhiuyf47832urb32yfbe2fy2beufjb23yfb23iufkb2';
            $linkToken = Str::random(50);

            $opera = DB::table('operateurs')->where('payment_method', $request->payment_method)->first();
            if ($opera) {
                $data = DB::table('initiate_transactions')->insert([
                    'currency' => $request->currency,
                    'payment_method' => $request->payment_method,
                    'merchant_transaction_id' => $request->merchant_transaction_id,
                    'amount' => $request->amount,
                    'success_url' => $request->success_url,
                    'failed_url' => $request->failed_url,
                    'notify_url' => $request->notify_url,
                    'refercence_cl' => $request->refercence_cl,
                    'link_token' => $linkToken
                ]);
                $response = [
                    'statut_token' => $linkToken,
                    'payment_url' => route('faire-un-paiement',$linkToken)
                ];

                return response($response, 201);
            } else {
                $response = [
                    'err' => [
                        'code' => 401,
                        'message' => 'PAYMENT_METHOD_NOT_EXIST'
                    ]
                ];
                return response($response, 401);
            }
        } catch (\Exception $ex) {


            $errorCode = 400;
            $errorMessage = $ex->getMessage();
            if (strpos($errorMessage, 'must be unique') !== false||strpos($errorMessage, 'Duplicate entry')!== false) {
                $errorCode = 500;
                $errorMessage = 'TRANSACTION_EXIST';
            }
            $response = [
                'err' => [
                    'code' => $errorCode,
                    'message' => $errorMessage
                ]
            ];
            return response($response, $errorCode);
        }
    }
}

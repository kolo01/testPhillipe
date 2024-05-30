<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 


    public function TestaddInitiateTransac(Request $request)
    {
        try {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789jhefbiueqjbfwqiubfhiuyf47832urb32yfbe2fy2beufjb23yfb23iufkb2';
            $linkToken = Str::random(50);

            $opera = DB::table('operateurs')->where('payment_method', $request->payment_method)->first();
            if ($opera) {
                $data = DB::table('initiate_transaction')->insert([
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
                   
                $payment_url = 'http://localhost:8500/faire-un-paiement/' . $linkToken;

                return redirect($payment_url);

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
            if (strpos($errorMessage, 'must be unique') !== false) {
                $errorCode = 1200;
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

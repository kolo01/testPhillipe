<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Orange\Transaction_op;
use App\Http\Traits\Orange\Validated_transaction;
use App\Http\Traits\Orange\Failed_transaction;
use App\Http\Traits\addInitiateTransac;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    use Transaction_op, Validated_transaction, addInitiateTransac;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    // public function __construct()
    // {
    //     $this->middleware('auth:web', ['except' => ['openView','openLink','initiateTransaction']]);
    // }


    public function index()
    {
        $paiement = [];

        return view('paiements.paiement', compact('paiement'));
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
    public function initiateTransaction(Request $request)
    {

       $result = $this->Transaction_op($request);

       return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validatedTransaction(Request $request)
    {
        $result = $this->Validated_transaction($request);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function test()
    {  
        try {
            DB::connection()->getPdo();
            echo "Connected to the database.";
        } catch (\Exception $e) {
            echo "Not connected to the database. Error: " . $e->getMessage();
        }
       // dd(DB::table('users')->get());
        return view('formualaire');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function FailededTransaction(Request $request)
    {
        $result = $this->Failed_transaction($request);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function openView(Request $request)
    {


        $result = $this->addInitiateTransac($request);

        return $result;
    }


    public function checkStatus(Request $request)
    {

    }



    public function openLink($id){

        $initiate_operation = DB::table('initiate_transactions')->where('link_token', $id)->first();
        // var_dump($initiate_operation);
        // die();

        // if(!$initiate_operation){
        //     $initiate_operation["payment_method"] = "null";

        // }
        return view("paiement.faire-un-paiement", ["paiement"=>$initiate_operation]);
    }
}


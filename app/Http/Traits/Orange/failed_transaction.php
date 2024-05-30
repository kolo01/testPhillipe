<?php
namespace App\Http\Traits\Orange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Failed_transaction {

    protected function Failed_transaction($body)
    {
      
        $order_id = $body->input('qw');
    
        DB::table('transactions')->where('id', $order_id)->update(["statut" => 'FAILED']);
    
        return response()->json(301);
 
    }


}
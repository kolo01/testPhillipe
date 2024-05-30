<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendMailBpay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ManageEmailBpayController extends Controller
{

//http://localhost:82/Consulting/babimo/api/v1/sendemailto

public function verificateOTP(Request $request)
{

    try {
            $email = request()->email;
            $otp_code = request()->otp_code;
            $checkMail = DB::table('users')->where('email', $email)->exists();
            $to = $email;
            $subject = "Vérification de code OTP";
            $message = 'Votre code de vérification est : ' .$otp_code;
          
        if ($checkMail) {
            // Envoyer l'e-mail
           // $result = Mail($to, $subject, $message);
            Mail::to($email)->send(new SendMailBpay($otp_code));
            return response()->json(['message' => "Email envoyé avec succès", 'statut' => 200]);
        } else {
            return response()->json(['message' => "Désolé cette adresse n'existe pas dans notre base de donnée", 'status' => 404]);
        }
    
    } catch (\Throwable $e) {
        return response()->json(['message' => $e->getMessage(), 'status' => 500]);
    }
    

  
}



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMailBpay;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class LoginController_old extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request)
    {
           return view('compte.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verificatedOtp(Request $request)
    {
           
        try {
                $email = $request->email;
                $otp_code = $request->code_otp;
                $checkMail = DB::table('users')->where('email', $email)->exists();
                $to = $email;
                $subject = "Vérification de code OTP";
                $message = 'Votre code de vérification est : ' .$otp_code;
            if ($checkMail) {
                // Envoyer l'e-mail
                // $result = Mail($to, $subject, $message);
                Mail::to($email)->send(new SendMailBpay($otp_code));
                return response()->json(['message' => "Email envoyé avec succès", 'status' => 200, 'email' => $email]);
            } else {
                return response()->json(['message' => "Désolé cette adresse n'existe pas dans notre base de donnée", 'status' => 404, 'email'=>""]);
            }
        
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
            
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginOTP(Request $request)
    {
        return view('compte.otp-code');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkOTP(Request $request)
    {   
        $credentials = [];
        $email = $request->email;
        $code = User::where('email', $email)->first()->code;
       // $credentials = Auth::attempt(['email' => $email, 'password' => $code]);
        $credentials = auth('web')->attempt(['email' => $email, 'password' => $code]);
        // Tenter l'authentification avec les données fournies
        // $user = Auth::user();
        if ($credentials) {
           
            // L'authentification a réussi, l'utilisateur est connecté
            $user =  User::where('email', $email)->first();
            Auth::login($user);
          //  dd("ssss");
            return redirect()->route('dashboard.index');
        } else {
            // L'authentification a échoué, rediriger vers la page de connexion avec un message d'erreur
            return redirect('/login')->with('error', 'Identifiants invalides');
        }
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
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

}

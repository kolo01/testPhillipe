<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMailBpay;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\generateOtp;
use Illuminate\Support\Carbon;
use App\Models\VerificationCode;
use App\Http\Traits\sendSMS;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use generateOtp, sendSMS;

    public function login(Request $request)
    {
           return view('auth.login-by-phone');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */

        // Generate OTP
    public function generate(Request $request)
    {
        $connexion_mode = isset($request->connexion_mode) ? $request->connexion_mode  : "aucun";

        if ($connexion_mode == 'telephone') {
            // Vérifier si la valeur est un chiffre
            if (is_numeric($request->telephone)) {
                // Vérifier si la valeur a 10 chiffres
                if (strlen($request->telephone) === 10) {
                    $checkuserExist = User::where('telephone', $request->telephone)->exists();
                    if (!$checkuserExist) {
                        return redirect()->back()->with('error', "Ce numero de téléphone n'existe pas dans la base.");
                    }

                    # Generate An OTP
                    $verificationCode = $this->generateOtp($request->telephone);

                    $message = "Bpay - code de validation: ".$verificationCode->otp.". Ne partagez ce code qu'avec un agent Bpay lors d'une transaction. Ce code expire dans 5 minutes.";
                    $this->sendSmsOtp($request->telephone, $message);
                    # Return With OTP
                    return redirect()->route('otp.verification', ['code' => $verificationCode->user_code])->with('success',  $message);
                } else {
                    return redirect()->back()->with('error', "Le numero de téléphone doit etre égale à 10 chiffres.");
                }
            } else {
                return redirect()->back()->with('error', "Le numero de téléphone ne doit comporter que des chiffres.");
            }
        } elseif ($connexion_mode == 'email') {
            // Vérifier si il s'agit bien d'un email
            if (strpos($request->email, '@') !== false) {
                $checkuserExist = User::where('email', $request->email)->exists();
                if (!$checkuserExist) {
                    return redirect()->back()->with('error', "Cette adresse email n'existe pas dans la base.");
                }
                # Generate An OTP
                $verificationCode = $this->generateOtpByEmail($request->email);

                $message = " ".$verificationCode->otp." ";
                Mail::to($request->email)->send(new SendMailBpay($message));
                # Return With OTP
                return redirect()->route('otp.verification', ['code' => $verificationCode->user_code])->with('success',  $message);
            } else {
                return redirect()->back()->with('error', "Veuillez saisir une adresse email valide.");
            }
        }else {
            return redirect()->back()->with('error', "Veuillez saisir un identifiant valide.");
        }


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verification($code)
    {
        return view('auth.otp-checking')->with([
            'code' => $code
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loginWithOtp(Request $request)
    {

        $otp = $request->otp[0].''.$request->otp[1].''.$request->otp[2].''.$request->otp[3];

        #Validation
        $request->validate([
            'code' => 'required|exists:users,code',
        ]);

        #Validation Logic
        $verificationCode   = VerificationCode::where('user_code', $request->code)->where('otp', $otp)->first();
        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', "Votre code OTP est incorrecte");
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return redirect()->route('otp.login')->with('error', 'Votre code OTP a expiré');
        }

        $user = User::whereCode($request->code)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

           //Auth::attempt(['email'=>$user->email, 'password'=>$user->code]);
            if (Auth::user()->role == 'deposant') {
              return redirect()->intended('/suivi-affilier');
            }
            return redirect()->intended('/');
        }

        return redirect()->route('otp.login')->with('error', "Votre code OTP est incorrecte");
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

        return redirect()->route('otp.login');
    }

    public function generateOtpByEmail($email)
    {
        $user = User::where('email', $email)->first();

        $verificationCode = VerificationCode::where('user_code', $user->code)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        return VerificationCode::create([
            'user_code' => $user->code,
            'otp' => rand(1234, 9999),
            'expire_at' => Carbon::now()->addMinutes(5)
        ]);
    }

}

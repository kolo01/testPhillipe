<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Operateur;
use Illuminate\Support\Carbon;
use App\Models\VerificationCode;
use App\Models\User;

trait generateOtp
{

    public function generateOtp($telephone)
    {
        $user = User::where('telephone', $telephone)->first();
       
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_code', $user->code)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_code' => $user->code,
            'otp' => rand(1234, 9999),
            'expire_at' => Carbon::now()->addMinutes(5)
        ]);
    }

}
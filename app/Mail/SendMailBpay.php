<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailBpay extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param  string  $verificationCode
     *
     * @return void
     */
    protected $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {      
         $otp = $this->verificationCode;

        return $this->from('no-reply@example.com', 'Bpay') // L'expéditeur
                    ->subject("Vérification de code OTP") // Le sujet
                    ->view('email.bpay', ['otp' => $otp]);
    }
}

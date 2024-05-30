<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailRetrait extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param  string  $retrait
     *
     * @return void
     */
    protected $retrait;

    public function __construct($retrait)
    {
        $this->retrait = $retrait;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {      
        $retrait = $this->retrait;
  
        return $this->from('no-reply@babimo.com', 'Bpay') // L'expéditeur
                    ->subject("Confirmation de demande de retrait") // Le sujet
                    ->view('email.demande-retrait', ['retrait' => $retrait]);
    }
}

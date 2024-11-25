<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetraitRibValidate extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  protected $nom_marchand;
  protected $montant;
  protected $telephone;


  public function __construct(
    $nom_marchand,
    $montant,
    $telephone
  ) {
    $this->nom_marchand = $nom_marchand;
    $this->montant = $montant;
    $this->telephone = $telephone;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $nom_marchand = $this->nom_marchand;
    $montant = $this->montant;
    $telephone = $this->telephone;

    return $this->from('no-reply@example.com', 'Bpay') // L'expéditeur
      ->subject("validation de retrait") // Le sujet
      ->view('email.validateRib', [
        'nom_marchand' => $nom_marchand,
        'montant' => $montant,
        'telephone' => $telephone
      ]);
  }
}

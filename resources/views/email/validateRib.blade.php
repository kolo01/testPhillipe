<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body style="color:#000000;">
  <h2>Validation de la demande de retrait</h2>
  {{-- <p>de <b>{{$montant}},</b></p> --}}
  <p>Chers Mr/Mme/M {{$nom_marchand}}</p>
  <p>Votre demande de retrait a été reçue et validée. Voici un récapitulatif de votre demande :</p>
     <ul>
        <li>Montant demandé : {{$montant}}</li>
        <li>Statut de la demande : Validé</li>
        <li>Numéro de téléphone associé : {{$telephone}}</li>
    </ul>
    <p>Merci pour votre confiance et votre patience!</p>
  <p>Cordialement,<br>
  </body>
</html>

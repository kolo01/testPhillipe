<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body style="color:#000000;">      
  <h2>Confirmation de demande de retrait</h2>
  <p>Bonjour cher Administrateur,</p>
  <p>{{$retrait->nom_marchand}} a effectué(e) une demande de retrait. Voici un récapitulatif de la demande :</p>
     <ul>
        <li>Montant demandé : {{$retrait->montant}}</li>
        <li>Statut de la demande : En cours de traitement</li>
        <li>Numéro de téléphone associé : {{$retrait->telephone}}</li>
    </ul>
    <p>Nous vous tiendrons informé de l'avancement.</p>
  <p>Cordialement,<br>
  </body>
</html>
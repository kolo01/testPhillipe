<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body style="color:#000000;">      
  <h2>Information de retrait</h2>
  <p>Bonjour cher {{$retrait->nom_marchand}},</p>
  <p>Nous avons le plaisir de vous informer que votre demande de retrait a été validée avec succès.</p>
     <ul>
        <li>Montant retiré : {{$retrait->montant}} F.CFA</li>
        <li>Frais de retrait : {{$retrait->frais}} F.CFA</li>
        <li>Numéro de téléphone associé : {{$retrait->telephone}}</li>
    </ul>
    <p>Babimo vous remercie pour la confiance.</p>
  <p>Cordialement,<br>
  </body>
</html>
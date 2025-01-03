
/*=========================================================================================
    File Name: transaction.js
    Description: gérer les transactions de BPAY
    --------------------------------------------------------------------------------------
    Version: 1.0
==========================================================================================*/


$(function () {
     //* =======================Chargement à l'affichage de la liste des transactions=======================================
     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Initialisation de DataTable
    var table = $('#suivi-transaction').DataTable({
      processing: true,
      serverSide: true,
      language: {
          processing: "Traitement en cours...",
          search: "Rechercher&nbsp;:",
          lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
          info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
          infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
          infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          infoPostFix: "",
          loadingRecords: "Chargement en cours...",
          zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
          emptyTable: "Aucune donnée disponible dans le tableau",
          paginate: {
              first: "Premier",
              previous: "Pr&eacute;c&eacute;dent",
              next: "Suivant",
              last: "Dernier"
          },
          aria: {
              sortAscending: ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      ajax: {
          url: search, // URL vers l'API côté serveur
          type: 'POST',     // Méthode HTTP utilisée
          data: function (d) {
              // Ajout des champs de recherche personnalisés à la requête
              d.id_paie = $('#search-id_paie').val();         // Recherche par paie
              d.marchand = $('#search-marchand').val();       // Recherche par marchand
              d.status = $('#search-status').val();
              d.modepaiement = $('#search-modepaiement').val();
              d.type = $('#search-type').val();
              d.periode_debut = $('#search-date-start').val(); // Date de début
              d.periode_fin = $('#search-date-end').val();     // Date de fin
          }
      },
      columns: [       
        { data: 'transacmontant' },           // Montant de la transaction
        { data: 'montantfrais' },             // Montant des frais
        { data: 'montant_avec_frais' },       // Montant avec frais
        { data: 'modepaiement' },             // Mode de paiement
        { data: 'fraistransaction' },         // Frais de la transaction
        { data: 'marchand_id' },              // ID du marchand
        { data: 'marchand_nom' },             // Nom du marchand
        { data: 'country' },                  // Pays
        { data: 'merchant_transaction_id' },  // Transaction ID côté marchand
        { data: 'id_initiate_transaction' },  // ID de l'initiation de transaction
        { data: 'notif_token' },              // Token de notification
        { data: 'statut' },                   // Statut
        { data: 'type' },                     // Type de la transaction
        { data: 'ajust' },
        { data: 'created_at' },       
    ]
  });
  // Rafraîchir le tableau lorsque les champs de recherche changent
  $('#btn-search').on('click', function () {
      table.draw(); // Recharge les données du tableau avec les nouveaux filtres
  });

//     $(".chargement").html(loader).show();
//     $(".listetransaction").hide();
    
//     setTimeout(function() {
//         $(".chargement").hide();
//         $(".listetransaction").show();
//     }, 700);

//      //*======================variable declaration===========================================================================

//   afficheGetAll(html);

//   function afficheGetAll(html) {
//      $(".listetransaction").html(html).show();
//   }

//   function afficheByAjax(url) {
//     $.ajax({
//       url: url,  // Remplace par l'URL de ton API ou endpoint
//       type: 'GET',
//       success: function(response) {
//         afficheGetAll(response);
//       },
//       error: function(xhr, status, error) {
//           console.error("Erreur afficheByAjax : " + error);
//       }
//     });
//   }
//   //*=======================Rechercher TRANSACTION=======================
//   $("#FormRechtransaction").on('submit', function(e) { 
//      e.preventDefault();
//      var formdata =  $(this).serialize();
//      console.log(formdata)
//      $.ajax({
//       type:'post',
//       async:true,
//       data:formdata,
//       url:searcht,
//       beforeSend:function() {
//         $(".chargement").html(loader).show();
//       },
//       success:function(data) {
//         console.log(data)
//         $(".chargement").html(loader).hide();
//         afficheGetAll(data);
//       },
//       error:function(err) {
//         console.log(err);
//       }

//      })

//   })
//   //*====================================================================

// //*======================action de pagination
// $('.page-item a.page-link').click(function(e){
//   alert("paginate");
//   e.preventDefault();
//   var url = $(this).attr('href');
//   afficheByAjax(url);
// });
// //*======================Fin pagination

});
   
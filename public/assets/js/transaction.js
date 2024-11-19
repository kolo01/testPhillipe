
/*=========================================================================================
    File Name: app-transaction.js
    Description: gérer les transactions de BPAY
    --------------------------------------------------------------------------------------
    Version: 1.0
==========================================================================================*/


$(function () {
     //* =======================Chargement à l'affichage de la liste des règles de sécurité=======================================
     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(".chargement").html(loader).show();
    $(".listetransaction").hide();
    
    setTimeout(function() {
        $(".chargement").hide();
        $(".listetransaction").show();
    }, 700);

     //*======================variable declaration=======================

  afficheGetAll(html);

  function afficheGetAll(html) {
     $(".listetransaction").html(html).show();
  }
  //*=======================Rechercher TRANSACTION=======================
  $("#FormRechtransaction").on('submit', function(e) { 
     e.preventDefault();
     var formdata =  $(this).serialize();
     console.log(formdata)
     $.ajax({
      type:'post',
      async:true,
      data:formdata,
      url:searcht,
      beforeSend:function() {
        $(".chargement").html(loader).show();
      },
      success:function(data) {
        console.log(data)
        $(".chargement").html(loader).hide();
        $(".listetransaction").html(data).show();
        //delAnddetail();
      },
      error:function(err) {
        console.log(err);
      }

     })

  })
  //*====================================================================

//*======================action de pagination
$('.page-link').on('click', function(e) {
  e.preventDefault();
  alert("page-link");
  // Récupère l'URL de la page cliquée
  var pageUrl = $(this).attr('href');
  // Si l'élément n'a pas de lien (dans le cas d'un span pour la page active), on arrête
  if (!pageUrl) {
      return;
  }
  // Récupère le numéro de page
  var page = pageUrl.split('page=')[1];
  // Appelle la fonction pour charger la page
  fetch_page(page);
});
//*======================Fin pagination


//*======================Fonction de Pagination

function fetch_page(page) {
$.ajax({
    url:pagination,
    data:'page= '+ page ,
    type:'get',
    success: function(response) {
    $(".listetransaction").html(response).show();
    $(".pagination").html($(response).find(".pagination").html());
    },  
 });

}
//*======================Fin Pagination






});
   

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

    $(".chargement").html(loader).show();
    $(".listetransaction").hide();
    
    setTimeout(function() {
        $(".chargement").hide();
        $(".listetransaction").show();
    }, 700);

     //*======================variable declaration===========================================================================

  afficheGetAll(html);

  function afficheGetAll(html) {
     $(".listetransaction").html(html).show();
  }

  function afficheByAjax(url) {
    $.ajax({
      url: url,  // Remplace par l'URL de ton API ou endpoint
      type: 'GET',
      success: function(response) {
        afficheGetAll(response);
      },
      error: function(xhr, status, error) {
          console.error("Erreur afficheByAjax : " + error);
      }
    });
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
        afficheGetAll(data);
      },
      error:function(err) {
        console.log(err);
      }

     })

  })
  //*====================================================================

//*======================action de pagination
$('.page-item a.page-link').click(function(e){
  alert("paginate");
  e.preventDefault();
  var url = $(this).attr('href');
  afficheByAjax(url);
});
//*======================Fin pagination

});
   
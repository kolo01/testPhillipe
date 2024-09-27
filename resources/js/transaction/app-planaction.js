
/*=========================================================================================
    File Name: app-planaction.js
    Description: gérer les planactions de sécurité
    --------------------------------------------------------------------------------------
    Version: 1.0
==========================================================================================*/


$(document).ready(function () {
     
    
   //* =======================Chargement à l'affichage de la liste des règles de sécurité=======================================

    $('.planaction-error').removeClass('error');
  

    $('.listeplanaction').removeClass('row col-md-12 align-center justify-content-center spinner-border spinner-border-lg');
  
   
    var isRtl = $('html').attr('data-textdirection') === 'rtl';

    $(".chargement").html('<img src="/loading/loading.gif" style="width:65px; height:65px;text-align:center;" />').show();

    $(".listeplanaction").hide();

    randomChar('abcdefghijklmnopqrstuvwxyz0123456789');

    setTimeout(function() {

        $(".chargement").html('<img src="/loading/loading.gif" style="width:65px; height:65px;text-align:center;" />').hide();

        $(".listeplanaction").show();

        afficheplanaction('0');

    }, 700);

    
   
     //*======================variable declaration=======================

     form = $('.form-validate');
     
   
     $.ajaxSetup({

       headers: {

           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
   
   
     $("#FormRechPlanaction").on('submit', function(e) { 
          e.preventDefault()
          var formdata =  $(this).serialize();
         // console.log(formdata)
            afficheplanaction(formdata);
      });

      $("input[name=rechArchive]").on('keyup', function(e) { 
        e.preventDefault()
        var formdata =  $("#formArchive").serialize();
         console.log(formdata)
          afficheplanaction(formdata);
    });


 function afficheplanaction(val) {
     
        $.ajax({
            type:'get',
            async:true,
            data:val,
            url:'getplanaction',
            success:function(data) {
              $(".listeplanaction").html(data).show();
              delAnddetail();
            },
        });

        $.ajax({
          type:'get',
          async:true,
          data:val,
          url:'getarchive',
          success:function(data) {
            $(".listearchive").html(data).show();
            delAnddetail();
          },
      });
        
function delAnddetail(){

  //*======================Suppression des planactions 

    $('.confirm-planaction-delete').on('click', function () {

        var planactions_id = $(this).attr('data-id');
           
       Swal.fire({
        title: 'Etes vous sûre de vouloir supprimer ce plan d\'action ?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimez-le!',
        confirmButtonClass: 'btn btn-warning',
        cancelButtonClass: 'btn btn-danger ml-1',
        cancelButtonText: 'Annuler',
        buttonsStyling: false,
      }).then(function (result) {
        if (result.value) {
        $.ajax({ 
            url:'planactions/delete',
            data:'planactions_id='+ planactions_id,
            type:'post',
            success:function(data) {
                console.log(data);
                if (data == 1) {
                    Swal.fire({
                        icon: "error",
                        title: 'Désolé impossible de supprimer ce planaction!',
                        text: 'Elle doit être rattachée à une ou plusieurs informations',
                        confirmButtonClass: 'btn btn-success',
                    })
                } else {
                    Swal.fire({
                        icon: "success",
                        title: 'Supprimer!',
                        text: 'Votre enregistrement a été supprimé',
                        confirmButtonClass: 'btn btn-success',
                    })
                }

               afficheplanaction('0');
            },

            error:function(error) {
                console.log("Error 500 : "+ error);
            }
    
        });

        } else if (result.dismiss === Swal.DismissReason.cancel) {

        Swal.fire({
            title: 'Annulé',
            text: 'Suppression Annuler !',
            icon: 'error',
            confirmButtonClass: 'btn btn-success',

         })

        }

      })

    });

 //*======================Fin suppression =======================

   //*======================Archivage des planactions 

   $('.confirm-planaction-archivage').on('click', function () {

    var planactions_id = $(this).attr('data-id');
       
   Swal.fire({
    title: 'Etes vous sûre de vouloir éffectuer cette action ?',
   // text: "Vous ne pourrez pas revenir en arrière!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Oui',
    confirmButtonClass: 'btn btn-warning',
    cancelButtonClass: 'btn btn-danger ml-1',
    cancelButtonText: 'Non',
    buttonsStyling: false,
  }).then(function (result) {
    if (result.value) {
    $.ajax({ 
        url:'archivage',
        data:'planactions_id='+ planactions_id,
        type:'post',
        success:function(data) {
            console.log(data);
            if (data == 1) {
                Swal.fire({
                    icon: "error",
                    title: 'Désolé impossible d\'archiver ce plan d\'action !',
                    text: 'Il doit être rattaché à une ou plusieurs exigences de sécurité',
                    confirmButtonClass: 'btn btn-success',
                })
            } else {
                Swal.fire({
                    icon: "success",
                    title: 'Archivage!',
                    text: 'Ce plan d\'action est archivé avec succès',
                    confirmButtonClass: 'btn btn-success',
                })
            }

           afficheplanaction('0');
        },

        error:function(error) {
            console.log("Error 500 : "+ error)
        }

    });

    } else if (result.dismiss === Swal.DismissReason.cancel) {

    Swal.fire({
        title: 'Annulé',
        text: '',
        icon: 'error',
        confirmButtonClass: 'btn btn-success',

     })

    }

  })

});

//*======================Fin archivage des plans d'action =======================


 //*======================Modification planaction

 $('.edit-planaction').on('click', function() {
  
  var eq_id = $(this).attr('data-id');

   $.ajax({

       type:'post',
       async:true,
       data:'eq_id=' + eq_id,
       url:'redirect/mod-planaction',
       success:function(data) {
  
        $('.afficheplanaction').html(data).show();

       },
 });

});

 //*======================Fin modification des règles de sécurité=======================

  //*======================Detail planaction
  $('.detail-planaction').on('click', function() {
    
    var eq_id = $(this).attr('data-id');
 
     $.ajax({
  
         type:'post',
         async:true,
         data:'eq_id=' + eq_id,
         url:'redirect/detail-planaction',
         success:function(data) {
             
          $('.detailplanaction').html(data).show();
  
         },
   });
  
  });
   //*======================Fin Detail planaction=======================


   
//*======================pagination

    $(document).on('click', '.pagination a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
       fetch_data(page);
       
   });
//*======================Fin pagination


      //*======================Pagination

  function fetch_data(page) {
     
    $.ajax({
        url:'getplanaction',
        data:'page= '+ page ,
        type:'get',
        success: function(data) {
        $(".listeplanaction").html(data).show();
        delAnddetail();
        },  
     });

}
  //*======================Fin Pagination
  
  }
  




}
    
   
//*======================Enegistrement des planactions
     $('.form-add-planaction').on('submit', function(e) {
  
       e.preventDefault();
     
      var formdata =  $(this).serialize();

     // formdata += "&regles_id=" + encodeURIComponent($("#regles_id").val());
     console.log($('.form-add-planaction').attr('redirection')) 
   
         $.ajax({
           url:$(this).attr('action'),
           data:formdata,
           type:'post',
           beforeSend:function() {

            $('#save-plan').addClass('spinner-border spinner-border-sm');
            $('#btn-save-plan').addClass('disabled');
            $('#close').addClass('disabled');
            
           },
           success:function(data) {
            if (data == 2) {
               toastr['success']('Sauvegarde effectuée avec succès.', 'Enregistrement plan d\'action', {
                   showMethod: 'slideDown',
                   hideMethod: 'slideUp',
                   timeOut: 2000,
                   closeButton: true,
                   tapToDismiss: false,
                   progressBar: true,
                   rtl: isRtl
                 });

                 $('#save-plan').removeClass('spinner-border spinner-border-sm');
                 $('#btn-save-plan').removeAttr('disabled');
                 $('#close').removeAttr('disabled');

                 $('.form-add-planaction')[0].reset();
                  //  $(location).attr('href', $(form).attr('routes'));
                 //$("#addplanactionModal").modal("hide");

                 window.location.href = '/app/planactions';

                 randomChar('abcdefghijklmnopqrstuvwxyz0123456789');
                   
            } else {

               $('.planaction-error').addClass('error');
               toastr['error']('Veuillez saisir un autre plan d\'action car celui-ci existe déjà  dans la base de données.', 'Erreur !', {
                   closeButton: true,
                   tapToDismiss: false,
                   rtl: isRtl
                 });

                 $('#save-plan').removeClass('spinner-border spinner-border-sm');
                 $('#btn-save-plan').removeClass('disabled');
                 $('#close').removeClass('disabled');
                 
                 randomChar('abcdefghijklmnopqrstuvwxyz0123456789');
            }
   
           },
           error:function(error) {
             console.log("Error 500 : "+ error)
           }
   
       });
   
   
     })
   
     //*======================Fin enregistrement des planactions=======================



    //*======================Modification des planactions

        $('.form-edit-planaction').on('submit', function(e) {
          
           e.preventDefault();
           
             var formdata =  $(this).serialize();

          // formdata += "&regles_id=" + encodeURIComponent($("#regles_id").val());
           
             $.ajax({
               url:$(this).attr('action'),
               data:formdata,
               type:'post',
               beforeSend:function() {

                 $('#modif-plan').addClass('spinner-border spinner-border-sm');
                 $('#btn-modif-plan').addClass('disabled');
                 $('#close').addClass('disabled');

               },

               success:function(data) {

                if (data == 2) {

                   toastr['success']('Modification effectuée avec succès.', 'Modification plan d\'action', {
                       showMethod: 'slideDown',
                       hideMethod: 'slideUp',
                       timeOut: 2000,
                       closeButton: true,
                       tapToDismiss: false,
                       progressBar: true,
                       rtl: isRtl
                     });

                     $('#modif-plan').removeClass('spinner-border spinner-border-sm');
                     $('#btn-modif-plan').removeClass('disabled');
                     $('#close').removeClass('disabled');
   
                   //$("#editplanactionModal").modal("hide"); 

                   window.location.href = '/app/planactions';

                } else {

                   $('.planaction-error').addClass('error');

                   toastr['error']('Veuillez saisir un autre plan d\'action car celui-ci existe déjà  dans la base de données.', 'Erreur !', {
                       closeButton: true,
                       tapToDismiss: false,
                       rtl: isRtl
                     });

                     $('#modif-plan').removeClass('spinner-border spinner-border-sm');
                     $('#btn-modif-plan').removeAttr('disabled');
                     $('#close').removeAttr('disabled');
                }
       
               },
               error:function(error) {
                 console.log("Error 500 : "+ error)
               }
       
           });
       
       
         })

    //*======================Fin modification des planactions




    //*=======================Rechercher Plan d'action
  // $("#FormRechPlanaction").on('submit', function(e) { 
  //    e.preventDefault();
  //    alert()
  //    var formdata =  $(this).serialize();
  //    console.log(formdata)
  //    $.ajax({
  //     type:'get',
  //     async:true,
  //     data:formdata,
  //     url:'getplanaction',
  //     success:function(data) {
  //       $(".listeplanaction").html(data).show();
  //       delAnddetail();
  //     },
  //     error:function(erro) {
  //       console.log(error);
  //     }

  //    })

  // })

    //*===============================================



//*======================Random le code de planactions 

 function randomChar(characters){
  
    var result = ""
    var charactersLength = characters.length;
    
    for ( var i = 0; i < 6 ; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    
   // $('#code').val(result.toUpperCase());

 }

  //*======================Fin Random le code de planactions 







   });
   
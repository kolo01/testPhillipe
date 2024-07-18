
$(document).ready(function () {
       
    $.ajaxSetup({
    
      headers: {
    
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    
    });
    
    
    async function checkTransactionStatus(formData) {
    
        loginBtn.setAttribute('disabled', true);
    
      try {
        
       var link = 'oauth/verificateStatus'
    
       $.ajax({
        url:link,
        data:formData,
        type:'post',
        cache:false,
        processData:false,
        contentType:false,
        success: function(response) {

         var result = response;

         console.log(result.status);

     
         console.log("Success:", result);

        },
        error: function(xhr, textStatus, errorThrown) {
              
        }
    
      });
    
        
      } catch (error) {
        console.log("Front status 500")
        console.error(error);
        
      }
    
    }
    
    
    //------------------------------------------------------------------------------   
    });
    
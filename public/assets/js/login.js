
$(document).ready(function () {
       
$.ajaxSetup({

  headers: {

      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }

});

//document.querySelector('meta[name="csrf-token"]').getAttribute('content')
// fetch(url, {
//   method: 'POST',
//   body: formData,
//   headers: {
//     'Nom-Header-1': 'Valeur-Header-1',
//     'Nom-Header-2': 'Valeur-Header-2'
//   }
// })
// .then(response => response.json())
// .then(data => {
//   console.log(data); // Traitement de la réponse du serveur
// })
// .catch(error => {
//   console.error(error); // Gestion des erreurs
// });

const loginBtn = document.querySelector('#connexion');
const form = document.querySelector('form');
var resp = {};
  // Générer le code OTP
var otp_generate = Math.floor(Math.random() * 10000);


async function loginByOtp(formData) {

    loginBtn.setAttribute('disabled', true);

  try {
    
   var link = 'oauth/verificatedOtp'

   $.ajax({
    url:link,
    data:formData,
    type:'post',
    cache:false,
    processData:false,
    contentType:false,
    success: function(response) {
      // Handle the success response
     var result = response;
     console.log(result.status);
     console.log("Front status 500 part try");

     if (result.status == 200) {
       Swal.fire({
         icon: 'success',
         title: 'Félicitation !',
         text: "Un code OTP vient de vous etes envoyer par email",
       });

       loginBtn.removeAttribute('disabled');
        // Get the domain with HTTP protocol
        var domain = window.location.origin;
        setTimeout(() => {
          window.location.href = domain + '/login-otp-code';
        }, 3000);
       // Stocker le code OTP et le timestamp d'expiration dans le localStorage
       var expirationTimestamp = Date.now() + 5 * 60 * 1000; // 5 minutes en millisecondes
       localStorage.setItem('otp_code', otp_generate);
       localStorage.setItem('otp_expiration', expirationTimestamp);
       localStorage.setItem('email', result.email);
       console.log("====><=========" + localStorage.getItem('otp_code'));
       // Vérifier si le code OTP est expiré
       function isOtpExpired() {
         var currentTimestamp = Date.now();
         var storedExpirationTimestamp = localStorage.getItem('otp_expiration');
         
         // Vérifier si le timestamp d'expiration est dépassé
         if (currentTimestamp > storedExpirationTimestamp) {
           // Le code OTP a expiré
           return true;
         }
         
         return false;
       }
 
       // Utiliser le code OTP
       if (!isOtpExpired()) {
         // Le code OTP est toujours valide
         var storedOtpCode = localStorage.getItem('otp_code');
         console.log('Code OTP:', storedOtpCode);
       } else {
         // Le code OTP a expiré, le supprimer du localStorage
         localStorage.removeItem('otp_code');
         localStorage.removeItem('otp_expiration');
         localStorage.removeItem('email');
         console.log('Le code OTP a expiré.');
       }
 
       var key = "otp_code";
 
       if (localStorage.getItem(key) !== null) {
         console.log("La clé existe dans le localStorage");
       } else {
         console.log("La clé n'existe pas dans le localStorage");
       }

        console.log(domain + '/login-otp-code');

       return result;
       
     } else if (result.status == 404) {
       Swal.fire({
         icon: 'error',
         title: 'Désolé !',
         text: "Cette adresse email ne figure pas dans notre base de données",
       })
       loginBtn.removeAttribute('disabled');
     } else {
         console.log("elsee part")
         console.log(result)
       Swal.fire({
         icon: 'error',
         title: 'Désolé !',
         text: "Une erreur s'est produite",
       })
       loginBtn.removeAttribute('disabled');
     }
 
     console.log("Success:", result);

     loginBtn.removeAttribute('disabled');

    },
    error: function(xhr, textStatus, errorThrown) {
          Swal.fire({
          icon: 'error',
          title: 'Désolé !',
          text: "Une erreur s'est produite",
      })
    }

  });

    
  } catch (error) {
    console.log("Front status 500")
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Désolé !',
      text: "Une erreur s'est produite",
    })

    loginBtn.removeAttribute('disabled');
    
  }

}

 const getLoginData = () => {
  const formData = new FormData(form); 
  formData.append("code_otp", otp_generate);
  return formData;
}

loginBtn.addEventListener('click', async function(e) {
   e.preventDefault();
    for (const value of getLoginData().values()) {
        console.log(value);
        console.log("===>>>>" + value)
        if (checkundefinded(value)) {
            Swal.fire({
                icon: 'error',
                title: 'Désolé !',
                text: "Veuillez renseigner votre adresse email",
            })
            return false;
        }
    }
   console.log("------");
   
 const result = await loginByOtp(getLoginData());

 return result;

});


const checkundefinded = (val) =>{
   result = (val == null || val == "" || val == undefined ) ? true : false;
   return result;
}


//------------------------------------------------------------------------------   
});

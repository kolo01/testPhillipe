

$(document).ready(function () {
       
  $.ajaxSetup({
  
    headers: {
  
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  
  });


  //--------------------------------------------API FECTH
//-------environment variable---------------

//------------------------------------------
const otpBtn = document.querySelector('#valide-otp');
const form = document.querySelector('form');
let otpValue = "";
var formOTP = document.getElementById('formOTP');
//const email = document.querySelector('#email').value;
var otpCookieValue = localStorage.getItem('otp_code');
var email = localStorage.getItem('email');
document.getElementById('email').value = email;


async function loginByOtp() {
  console.log(otpCookieValue);
  console.log(otpValue);
 var  otp = parseInt(otpValue);
    otpBtn.setAttribute('disabled', true);

   return  checkIfCodeExpired(otp, otpCookieValue);
}

   


function checkIfCodeExpired(otp, otpCookieValue) {

  const cookieValue = checkUndefined(otpCookieValue);
  if (cookieValue) {
    console.log('Le cookie est encore valide');
    if (otp == otpCookieValue) {
      console.log('Le code est correct');
      Swal.fire({
        icon: 'success',
        title: 'Félicitation !',
        text: "Vous etes connecté",
    })

    formOTP.submit();
    
      return true;
    } else {
      console.log('Le code est incorrect');
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Le code n'est pas valide ou est expiré",
    })
      return false;
    }
  } else {
    // Le cookie a expiré
    console.log('Le cookie a expiré.');
    return 0;
  }
}

function checkUndefined(val) {
  result = val == null || val == "" || val == undefined ? false : true;
  return result;
}


 const getLoginData = () => {
  const formData = new FormData(form); 
  //formData.append("title", 'lorem ipsum');
  return formData;
}

otpBtn.addEventListener('click', async function(e) {
   e.preventDefault();
    for (const value of getLoginData().values()) {
        console.log(value);
        console.log("===>>>>" + value)
        if (checkundefinded(value)) {
            Swal.fire({
                icon: 'error',
                title: 'Désolé !',
                text: "Veuillez renseigner tous le code à 5 chiffres",
            })
            return false;
        }

        otpValue += value + "";
    }
   console.log("------");

   loginByOtp();

 return true;



});


const checkundefinded = (val) =>{
   result = (val == null || val == "" || val == undefined ) ? true : false;
   return result;
}


//------------------------------------------------------------------------------


});

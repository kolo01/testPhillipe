
//--------------------------------------------API FECTH
//-------environment variable---------------
let app = 'dev';
let port = 10000;
let host = 'localhost';
//------------------------------------------
const otpBtn = document.querySelector('#payer');
const form = document.querySelector('form');
const UserName = document.querySelector("#nameUser");
var bedel = "bedel";
//const email = document.querySelector('#email').value;

async function Gotopaiment(formData) {

    otpBtn.setAttribute('disabled', true);

  try {
    
    if (app == 'prod') {
         port = 4000;
         host = 'localhost';
    }
    //http://localhost:4000/api/v1/oauth/checkedOtp
    const url = 'http://' + host + ':' + port + '/log';

    const response = await fetch(url, {
      method: "POST",
      body: formData,

    })
    .then(response => response.json())
    .then((result)=>{
        return result;
    });
  
    const result = response;
    console.log("Front status 500 part try",result)
    if (result.status == 200){
      Swal.fire({
        icon: 'success',
        title: 'Félicitation !',
        text: "Code OTP validé avec succès",
      })
      var dataReponse = JSON.stringify(result.Resp.data)
      localStorage.setItem("dataUser",dataReponse);

     var datauser = JSON.parse(localStorage.getItem("dataUser"));
      

      otpBtn.removeAttribute('disabled');
      // Get the domain with HTTP protocol

      var domain = window.location.origin;
      setTimeout(() => {
        //UserName.in = result.Resp.data;
         window.location.href = domain + '/';
      }, 3000);
       console.log(domain + '/');
      return result;
      
    } else if (result.status == 406 || result.status == 404 ) {
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Ce code otp n'est plus valable ou est incorrecte",
      })
      otpBtn.removeAttribute('disabled');
    } else {
        console.log("elsee part")
        console.log(result)
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Une erreur s'est produite",
      })
      otpBtn.removeAttribute('disabled');
    }

    console.log("Success:", result);

  } catch (error) {
    console.log("Front status 500")
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Désolé !',
      text: "Ce code otp n'est plus valable ou est incorrecte",
    })

    otpBtn.removeAttribute('disabled');
    
  }

}

 const getLoginData = () => {
  const formData = new FormData(form); 
  console.log("formData",formData);
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
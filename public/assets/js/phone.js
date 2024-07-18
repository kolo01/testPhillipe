const input = document.querySelector("#phone");
const errorMsg = document.querySelector("#error-msg");
const validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
const errorMap = ["Invalid number", "Invalid country code", "Trop court", "Trop long", "Numéro invalide"];

// initialise plugin
const iti = window.intlTelInput(input, {
    localizedCountries: {
        ci: "Cote d'Ivoire",
      },
      onlyCountries: ["ci"],
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js" //
});

const reset = () => {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
  validMsg.classList.add('d-none')
};

// on blur: validate
input.addEventListener('blur', () => {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
      validMsg.classList.remove("d-none");
    } else {
      input.classList.add("error");
      const errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
      validMsg.classList.add('d-none')
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
//alert( const queryString = window.location.href.split('/')[5])
//--------------------------------------------API FECTH
var payer = document.querySelector('#payer');

async function  Paiement(formData) {

  document.querySelector('#payer').setAttribute('disabled', true);

  if (!iti) {
    Swal.fire({
        icon: 'erreur',
        title: 'Désolé',
         text: "Veuillez saisir un numéro de téléphone valide !",
      })
    return ;
  }
  console.log(formData);
  const queryString = window.location.href.split('/')[5];
//alert(queryString);
  var data_send = {
    numero:formData,
    token_nofif:queryString
  }

  console.log("data_send =>",data_send);

  try {

    var domain = window.location.origin;
    const url_deploy =   domain+'/api/v1/transaction';
    const getPayment = await fetch(url_deploy,{
      method: "POST",
      body:JSON.stringify(data_send)
    });
    const resultPayment = await getPayment.json();
    console.log("resultPayment=>",resultPayment);

    // if(resultPayment.status == "Success"){




    // //   var rep =  await resultPayment.Resp.data.filter(item => {
    // //     return item.link_token == queryString;
    // // })
    // // console.log("RepLink:", rep[0]);


    // //     var myHeaders = new Headers();
    // //     myHeaders.append("Content-Type", "application/json");
    // //     const response = await fetch(url_local+"transaction", {
    // //       method: "POST",
    // //       headers: myHeaders,
    // //       body:JSON.stringify(rep[0])
    // //     });
    // //     const result = await response.json();
    // // console.log("=====>"+ result.status)
    // // if (result.status == "Success"){

    // //   // Swal.fire(
    // //   //   'Bravo !',
    // //   //   'Votre avez fait un transaction chez babimo',
    // //   //   'success'
    // //   // )
    // //   // document.forms[0].reset();
    // //   // document.querySelector('#payer').removeAttribute('disabled');
    // //   // setTimeout(() => {
    // //   //   window.location.reload();
    // //   // }, 5000);
    // //   if(rep[0].payment_method == "OM_CI"){
    // //     console.log("je suis ici");
    // //     setTimeout(() => {
    // //        console.log("je suis dans setTimeout");
    // //        window.location.href = result.Resp.data.payment_url;
    // //     }, 3000);
    // //   }
    // //   console.log("Success:", result.Resp.data);
    // // } else {
    // //   Swal.fire({
    // //     icon: 'erreur',
    // //     title: 'Désolé',
    // //      text: "Une erreur s'est produite",
    // //   })
    // // }
    // }else{
    //   Swal.fire({
    //     icon: 'erreur',
    //     title: 'Désolé',
    //      text: "Une erreur s'est produite",
    //   });
    // }

  } catch (error) {
    console.error("Error:", error);
    Swal.fire({
      icon: 'erreur',
      title: 'Désolé...',
      text: "Une erreur s'est produite",
    })
    document.querySelector('#payer').removeAttribute('disabled');
  }

}


 const data = () => {

  const photo_profile = document.querySelector('#photo_profile');
  const piece_recto = document.querySelector('#piece_recto');
  const piece_verso = document.querySelector('#piece_verso');

  const formData = new FormData(document.querySelector('form'));

  return formData;


}


payer.addEventListener('click', function(e) {
    e.preventDefault();
    var num = [];
    for (const value of data().values()) {
      num.push(value);
     console.log(num);
    }

    console.log("------");

    Paiement(num[1]);

 })




//------------------------------------------------------------------------------

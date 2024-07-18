//--------------------------------------------API FECTH

const registerBtn = document.querySelector('#valide-register');
const form = document.querySelector('form');



async function RegisterData(formData) {

    registerBtn.setAttribute('disabled', true);

  try {
    

    const url = apidomain + '/api/v1/marchand/addEntreprise'; 

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
        text: "Enregistrement effectué avec succès",
      })
      var dataReponse = JSON.stringify(result.Resp.data)
      localStorage.setItem("dataUser",dataReponse);

     var datauser = JSON.parse(localStorage.getItem("dataUser"));
      

      registerBtn.removeAttribute('disabled');
      // Get the domain with HTTP protocol

      var domain = window.location.origin;
      setTimeout(() => {
          window.location.reload();
      }, 3000);
       console.log(domain + '/');
      return result;
      
    } else if (result.status == 404 || result.status == 400 ) {
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Veuillez renseigner correctement le formulaire",
      })
      registerBtn.removeAttribute('disabled');
    } else {
        console.log("elsee part")
        console.log(result)
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Une erreur s'est produite",
      })
      registerBtn.removeAttribute('disabled');
    }

    console.log("Success:", result);

  } catch (error) {
    console.log("Front status 500")
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Désolé !',
      text: "Veuillez renseigner correctement le formulaire",
    })

    registerBtn.removeAttribute('disabled');
    
  }

}

 const getData = () => {
  const formData = new FormData(form); 
  //formData.append("title", 'lorem ipsum');
  return formData;
}

registerBtn.addEventListener('click', async function(e) {
   e.preventDefault();
    for (const value of getData().values()) {
        console.log(value);
        console.log("===>>>>" + value)
        if (checkundefinded(value)) {
            Swal.fire({
                icon: 'error',
                title: 'Désolé !',
                text: "Veuillez renseigner tous les champs du formulaire",
            })
            return false;
        }
    }
   console.log("------");
   
 const result = await RegisterData(getData());

 return result;

});


const checkundefinded = (val) =>{
   result = (val == null || val == "" || val == undefined ) ? true : false;
   return result;
}


//------------------------------------------------------------------------------

//--------------------------------------------API FECTH

const logoutBtn = document.querySelector('#logoutBtn');


logoutBtn.addEventListener('click', function(e) {
       e.preventDefault();
       logout();
})

async function logout() {

    logoutBtn.setAttribute('disabled', true);

  try {

    const url = frontdomain + '/logout';

    const response = await fetch(url, {
      method: "POST",
      body: {data:true},
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
        title: '',
        text: "Déconnecter avec succès",
      })

      Btn.removeAttribute('disabled');
      // Get the domain with HTTP protocol

      var domain = window.location.origin;
      setTimeout(() => {
         window.location.href = domain + '/login';
      }, 3000);
       console.log(domain + '/');
      return result;
      
    } else if (result.status == 406 || result.status == 404 ) {
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Une erreur s'est produite",
      })
      Btn.removeAttribute('disabled');
    } else {
        console.log("elsee part")
        console.log(result)
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Une erreur s'est produite",
      })
      Btn.removeAttribute('disabled');
    }

    console.log("Success:", result);

  } catch (error) {
    console.log("Front status 500")
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Désolé !',
      text: "Une erreur s'est produite",
    })

    Btn.removeAttribute('disabled');
    
  }

}



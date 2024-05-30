@extends('layout')

@section('content')
<div class="col-lg-9 col-md-8 mt-3">
    <div class="dashboard-body">
        <!-- row -->
        <div class="dashboard-wraper">
            <div class="row">
                <!-- Submit Form -->
                <div class="col-lg-12 col-md-12">
                    <form action="{{route('marchand.enregistrer')}}" method="post" enctype="multipart/form-data">
                                     @csrf
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">	
                                <h3 class="text-center">Ajouter un nouveau marchand</h3><br>
                                <div class="frm_submit_wrap">
                                    @if (session('error'))
                                        <div class="col-md-4  p-2 text-center">
                                            <div class="alert text-white alert-danger" style="background: #e2062c;" role="alert"> {{session('error')}} 
                                            </div>
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="col-md-4  p-2 text-center">
                                            <div class="alert text-white alert-success" style="background:green;"  role="alert"> {{session('success')}} 
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-row">
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Raison sociale</label>
                                            <input type="text" name="nom" class="form-control" required>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Numero du registre de commerce ou autre </label>
                                            <input type="text" name="registrecommerce" class="form-control" required>
                                        </div>
                                    
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <label>Information sur l'activité</label>
                                            <textarea class="form-control h-120" name="infobusiness" required></textarea>
                                        </div>
    
                                        <div class="form-group col-lg-4 col-md-4">
                                            <label>Contact</label>
                                            <input type="number" name="contact" class="form-control" required>
                                        </div>
    
                                        <div class="form-group col-lg-4 col-md-4">
                                            <label>DFE</label>
                                            <input type="file" name="dfe" class="form-control" required>
                                        </div>
    
                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>RCCM</label>
                                            <input type="file" name="rccm" class="form-control" required>
                                        </div>
    
                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Logo</label>
                                            <input type="file" name="logo" class="form-control" required>
                                        </div>
    

                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Prévision de transaction </label>
                                            <input type="number" name="prevision_transac" class="form-control">
                                        </div> 
                                        
                                        <div class="form-group col-lg-2 col-md-12">
                                            <label>Tranche  </label>
                                            <input type="text" min="1" max="4" name="tranche_transac" class="form-control" required>
                                        </div> 
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                                <a href="{{ route('marchand.index')}}" class="btn btn-danger ml-2 text-white" type="submit">Annuler & Retour</a>
                                <button class="btn btn-secondary ml-2" type="submit">Valider</button>
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- row Route::group(['middleware' => 'auth:jwt-api'], function () {
    // Routes protégées par JWT
});-->
    </div>
</div>


<script>
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
</script>

@endsection
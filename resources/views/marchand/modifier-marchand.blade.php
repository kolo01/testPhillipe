@extends('layout')

@section('content')

<div class="col-lg-9 col-md-8 mt-3">
    <div class="dashboard-body">
        <!-- row -->
        <div class="dashboard-wraper">
            <div class="row">
                <!-- Submit Form -->
                <div class="col-lg-12 col-md-12">
                    <form method="post" action="{{route('marchand.mise-ajour')}}" enctype="multipart/form-data">
                            @csrf
                  <div class="submit-page">
                    <!-- Information -->
                    <div class="frm_submit_block">
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
                        <h3 class="text-center">Modifier le marchand</h3><br>
                        <div class="frm_submit_wrap">
                            <div class="form-row">
                                <input type="hidden" id="___val"  name="id" value="{{$marchand->id}}">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Raison sociale</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $marchand->nom }}" required>
                                </div>

                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Numero du registre de commerce ou autre</label>
                                    <input type="text" name="registrecommerce" class="form-control" value="{{ $marchand->registrecommerce }}" required>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label>Information sur l'activité</label>
                                    <textarea class="form-control h-120" name="infobusiness">{{ $marchand->infobusiness }}</textarea>
                                </div>

                                <div class="form-group col-lg-4 col-md-4">
                                    <label>Contact</label>
                                    <input type="number" name="contact" class="form-control" value="{{ $marchand->contact }}" required>
                                </div>

                                <div class="form-group col-lg-4 col-md-4">
                                    <label>DFE</label>
                                    <input type="file" name="dfe" class="form-control" value="{{ $marchand->dfe }}" required>
                                </div>

                                <div class="form-group col-lg-4 col-md-12">
                                    <label>RCCM</label>
                                    <input type="file" name="rccm" class="form-control" value="{{ $marchand->rccm }}" required>
                                </div>

                                <div class="form-group col-lg-4 col-md-12">
                                      <label>Logo</label>
                                      <input type="file" name="logo" class="form-control" required>
                                  </div>

                                <div class="form-group col-lg-4 col-md-12">
                                    <label>Prévision de transaction</label>
                                    <input type="number" name="prevision_transac" class="form-control" value="{{ $marchand->prevision_transac }}">
                                </div> 

                                <div class="form-group col-lg-2 col-md-12">
                                    <label>Tranche</label>
                                    <input type="text" min="1" max="4" name="tranche_transac" class="form-control" value="{{ $marchand->tranche_transac }}" required>
                                </div> 

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12">
                        <a href="{{route('marchand.index')}}" class="btn btn-danger ml-2 text-white" type="submit">Annuler & Retour</a>
                        <button  class="btn btn-secondary ml-2" type="submit">Modifier</button>
                    </div>        
                </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>


<script>
    //--------------------------------------------API FECTH

const UpdateBtn = document.querySelector('#valide-registerMod');

const form = document.querySelector('form');



async function UpdateData(formData) {

    UpdateBtn.setAttribute('disabled', true);

  try {
    
    console.log('je suis dans le try')
    const url = apidomain + '/api/v1/marchand/updateEntreprise'; 
    var myHeaders = new Headers();
    var token = form.getAttribute('data-id');
    myHeaders.append("token", "Bearer "+token);

    const response = await fetch(url, {
      method: "POST",
      headers:myHeaders,
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
        text: "Modification effectuée avec succès",
      })
      var dataReponse = JSON.stringify(result.Resp.data)
      localStorage.setItem("dataUser",dataReponse);

     var datauser = JSON.parse(localStorage.getItem("dataUser"));
      

      UpdateBtn.removeAttribute('disabled');
      // Get the domain with HTTP protocol

      var domain = window.location.origin;
      setTimeout(() => {
          window.location.href = domain + '/liste-des-marchands';
      }, 3000);
       console.log(domain + '/');
      return result;
      
    } else if (result.status == 404 || result.status == 400 ) {
         
    console.log('je suis dans le 400')
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Veuillez renseigner correctement le formulaire",
      })
      UpdateBtn.removeAttribute('disabled');
    } else {
        console.log("elsee part")
        console.log(result)
      Swal.fire({
        icon: 'error',
        title: 'Désolé !',
        text: "Une erreur s'est produite",
      })
      UpdateBtn.removeAttribute('disabled');
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

    UpdateBtn.removeAttribute('disabled');
    
  }

}

 const getData = () => {
  const formData = new FormData(form); 
  //formData.append("title", 'lorem ipsum');
  return formData;
}

UpdateBtn.addEventListener('click', async function(e) {
   e.preventDefault();
    for (const value of getData().values()) {
        console.log(value);
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
   
 const result = await UpdateData(getData());

 return result;

});


const checkundefinded = (val) =>{
   result = (val == null || val == "" || val == undefined ) ? true : false;
   return result;
}


//------------------------------------------------------------------------------
</script>

@endsection
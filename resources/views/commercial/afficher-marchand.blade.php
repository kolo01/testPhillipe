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
                        <h3 class="text-center "style="color: #fff;background:#144273">Details de {{ $marchand->nom }} </h3><br>
                        <div class="frm_submit_wrap">
                            <div class="form-row">
                                <input type="hidden" id="___val"  name="id" value="{{$marchand->id}}">
                                <div class="form-group col-lg-12 col-md-12" >
                                  <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label>Raison sociale</label>
                                    <P type="text" name="nom" >{{ $marchand->nom }}</P>
                                  </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12">
                                  <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                  <label>Numero du registre de commerce ou autre</label>
                                    <P type="text">{{ $marchand->registrecommerce }}</P>
                                  </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 ">
                                  <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label>Information sur l'activité</label>
                                    <textarea readonly  class="col-lg-6" style="height: 200px" >{{$marchand->infobusiness}}</textarea>
                                </div>

                                <div class="form-group col-lg-12 col-md-12">
                                   <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label>Contact</label>
                                    <p type="number" >{{ $marchand->contact }}</p>
                                </div>



                                <div class="form-group col-lg-12 col-md-12">
                                   <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label>Prévision de transaction</label>
                                    <p type="number" readonly name="prevision_transac" >{{ $marchand->prevision_transac }}</p>
                                </div>

                                <div class="form-group col-lg-12 col-md-12">
                                   <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label>Tranche par transaction</label>
                                    <p type="text"  >{{ $marchand->tranche_transac }}</p>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                   <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                  <label>Tranche par retrait</label>
                                  <p type="text" >{{ $marchand->tranche_retrait }}</p>
                              </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12">
                      <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                        <a href="{{route('commercial.dashboard')}}"  class="btn btn-secondary ml-2"  type="submit">Retour</a>
                        <a href="{{route('commercial.pdf', ['id' => $marchand->id])}}" class="btn btn-danger ml-2 text-white"  >  <i class="ti-printer  fa-lg" style="color:white; margin-right:5px"></i>Imprimer</a>
                      </div>
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

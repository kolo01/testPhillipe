@extends('layout')

@section('content')

<div class="col-lg-9 col-md-8 col-sm-12 mt-3">
    <div class="dashboard-body">
    <div class="clearfix mb-3"></div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif
      <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <p class="text-center" style="font-size:2em;"> <span class="text-black">SOLDE <p>
                    <p class="text-center mb-3" style="font-size:2em;"> <span class="text-black text-bold">@if($solde >= 1000){{number_format($solde, 0, ' ', ' ')}} @else {{$solde}} @endif F.CFA</span><p>
                    <p class="text-black" style="font-style: italic;text-center;">Retrait de montant en toute sécurité depuis votre compte bpay vers votre compte mobile money</p> 
                    <p class="text-black" style="font-style: italic;color:#5499C7;font-weight:bold;">Veuillez noter que des frais de 2% seront déduits de chaque retrait effectué. Montant perçu = <span id="displayAmount">0</span>F</p> 
                    <form action="{{route('marchand.demanderetrait')}}" method="post">
                    <div class="input-group margin-bottom-sm mb-2">
                        <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">opérateur</span>
                        <select name="operator" class="form-control" id="" style="background:#fff;border:1px solid #DDE6ED;">
                             <option value="">choisir</option>
                             <option value="OM_CI">Orange Money</option>
                             <option value="WAVE_CI">Wave</option>
                             <option value="MOMO_CI">MTN Money</option>
                             <option value="MOOV_CI">Flooz</option>
                        </select>
                    </div>
                    <div class="input-group margin-bottom-sm mb-2">
                        <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">F.CFA</span>
                        <input class="form-control" name="montant" id="amount" min="500" type="number" placeholder="Montant" style="background:#fff;border:1px solid #DDE6ED;">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">F.CFA</span>
                        <input class="form-control" name="confirm_montant" min="500" type="number" placeholder="Confirmer le montant" style="background:#fff;border:1px solid #DDE6ED;">
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">Telephone</span>
                        <input class="form-control" name="telephone" min="100" type="tel" pattern="\d{10}"  placeholder="Exemple: 0700000000" style="background:#fff;border:1px solid #DDE6ED;">
                    </div>

                    <div class="form-group">
                        <button  class="btn btn-primary transfert" type="submit"> <span class="transfering">Demande en cours...<i class="fa fa-spinner fa-spin fa-fw"></i></span> <span class="initiate-transfert">Valider <i class="fa fa-check-alt fa-fw" aria-hidden="true"></i></span> </button>
                        <a href="" class="btn btn-danger text-white" type="submit">Annuler</a>
                    </div> 
                    </form>
                </div>  

            </div>
        </div>
      </div>

      <div class="card">
         <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <label for="link">Recevez un paiement via ce lien</label>
                    <div class="input-group">
                        <input type="text" value="{{$link}}" class="form-control" id="link" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text" id="copyButton" style="cursor: pointer;" title="copié ce lien">
                                <i class="fas fa-copy"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
      
    </div>    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard_property">
                <div class="table-responsive">
                    <div class="col-md-12 mb-3">
                       <h4 class="text-center">Liste des demandes de retraits</h4>
                    </div>
                    <table id="myTable" class="table" data-order='[[ 1, "desc" ]]'>
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Montant retiré</th>
                                <th scope="col">Montant perçu</th>
                                <th scope="col">Frais</th>
                                <th scope="col">Montant restant</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Mode de paiement</th>
                                @if(auth()->user()->role == "superAdmin")
                                 <th scope="col">Actions</th>
                                @endif
                            </tr> 
                        </thead>
                        <tbody>
                           @foreach($retraits as $retrait)
                           @php
                            $fraistransaction = App\Models\Transaction::where('notif_token', $retrait->notif_token)->first()->fraistransaction ?? '2';
                           @endphp

                            <tr>
                                <td>{{$retrait->telephone}}</td>
                                <td>{{$retrait->montant_retrait}}  fcfa</td>
                                <td>{{$retrait->montant_retrait - ($retrait->montant_retrait * 2/100)}}  fcfa</td>
                                <td>{{($retrait->montant_retrait * 2/100)}}  fcfa</td>
                                <td>{{intval($retrait->montant_restant)}}</td>
                                <td>{{date('d/mY H:i:s', strtotime($retrait->created_at))}}</td>
                                <td>
                                    @if($retrait->status == 'EN COURS') 
                                        <div class="_leads_status"><span class="active" style="background:#5499C7;color:#fff;">{{$retrait->status}}</span></div>
                                    @elseif($retrait->status == 'ECHOUE') 
                                        <div class="_leads_status"><span class="active" style="background:red;color:#fff;">{{$retrait->status}}</span></div>
                                    @elseif($retrait->status == 'SUCCES')
                                        <div class="_leads_status"><span class="active" style="background:green;color:#fff;">{{$retrait->status}}</span></div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dash_prt_thumb">
                                        @if($retrait->methodpaiement == "OM_CI")
                                             <img src="{{ asset('assets/img/image/operateurs/orange.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                         @endif
         
                                         @if($retrait->methodpaiement == "WAVE_CI")
                                             <img src="{{ asset('assets/img/image/operateurs/wave.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                         @endif
         
                                         @if($retrait->methodpaiement == "MTN_CI")
                                             <img src="{{ asset('assets/img/image/operateurs/mtn.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                         @endif
         
                                         @if($retrait->methodpaiement == "MOOV_CI")
                                             <img src="{{ asset('assets/img/image/operateurs/moov.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                         @endif
                                     </div>
                                </td>
                                @if(auth()->user()->role == "superAdmin")
                                <td>      
                                    @if($retrait->status  == 'EN COURS')
                                      <a href="{{ route('marchand.transfert', ['id' => $retrait->id]) }}" class="btn btn-sm btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir confirmer le retrait de {{$retrait->montant_retrait}} demandé par le marchand {{\App\Models\Marchand::find($retrait->marchand_id)->nom}} sur le numero de téléphone {{$retrait->telephone}} ?');"><i class="fas fa-check"></i></a>
                                      <a href="{{ route('marchand.canceltransfert', ['id' => $retrait->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler le retrait de {{$retrait->montant_retrait}} demandé par le marchand {{\App\Models\Marchand::find($retrait->marchand_id)->nom}} sur le numero de téléphone {{$retrait->telephone}} ?');"><i class="fas fa-times"></i></a>
                                    @endif
                               </td>
                                
                                @endif
                            </tr>           
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->
</div>
@endsection

@section('script')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('content')
        }
    });
    
    var copyButton = document.querySelector('#copyButton');
    var linkInput = document.querySelector('#link');

    var amount = document.querySelector('#amount');
    amount.addEventListener('input', function() {
        var inputValue = this.value;
        var fee = (inputValue * 2) / 100;
        var finalAmount = inputValue - fee;
        var formattedAmount = finalAmount.toLocaleString('fr-FR');
        document.getElementById('displayAmount').innerHTML = formattedAmount;
    });

    copyButton.addEventListener('click', ()=>{
        linkInput.select();
        //Je copie le texte dans le press papier
        document.execCommand('copy');
        //Déselectionné le texte 
        window.getSelection().removeAllRanges();
        new swal({
                title: "Félicitation!",
                text: "Lien de paiement copié",
                icon: "success",
                button: "Ok",
            });
    });

    $(document).ready(function() {
        $('.transfering').hide();
        $('.transfert').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            method: $('form').attr('method'),
            url: $('form').attr('action'),
            data: $('form').serialize(),
            beforeSend: function() {
                // Code exécuté avant l'envoi de la requêtes
                $('.initiate-transfert').hide();
                $('.transfering').show();
                $('.transfert').attr('disabled', true);
            },
            success: function(data) {
                // Code exécuté en cas de succès de la requête
                console.log(data);
                $('.initiate-transfert').show();
                $('.transfering').hide();
                if (data == 'retraitEnCours') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Un retrait est déjà en cours de traitement",
                        icon: 'error',
                        button: "Ok",
                    });  
                } 
                if (data == 'succeeded') {
                    new swal({
                        title: "Félicitation!",
                        text: "Demande envoyée avec succès",
                        icon: "success",
                        button: "Ok",
                    });
                    setTimeout(() => {
                        window.location.reload();
                        console.log('reload')
                    }, 3000);
                }else if (data == 301) {
                    new swal({
                        title: "Désolé demande impossible !",
                        text: "Ce service d'opération n'est pas encore disponible.",
                        icon: "error",
                        button: "Ok",
                    });  
                }else if (data == 'failed') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Veuillez vérifier le montant de la transaction.",
                        icon: 'error',
                        button: "Ok",
                    });  
                }else if (data == 'minimum') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Le montant minimum de demande de retrait est de 500 F.CFA",
                        icon: 'error',
                        button: "Ok",
                    });  
                }else if (data == 'lowbalance') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Votre solde est insuffisant",
                        icon: 'error',
                        button: "Ok",
                    });  
                }else if (data == 'isNotNumber') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Le numero de téléphone ne doit comporté que des chiffres",
                        icon: 'error',
                        button: "Ok",
                    });  
                } else if (data == 'isNotEqualTo') {
                    new swal({
                        title: "Demande échouée !",
                        text: "Le numero de téléphone doit etre égal à 10 chiffres",
                        icon: 'error',
                        button: "Ok",
                    });  
                } 
                $('.transfert').removeAttr('disabled');
    
            },
            error: function(xhr, status, error) {
                // Code exécuté en cas d'erreur de la requête 
                console.log(error);
                new swal({
                        title: "Désolé Demande échouée !",
                        text: "Veuillez ressayer car une erreur c'est produite.",
                        icon: "danger",
                        button: "Ok",
                    }); 
                    $('.transfert').removeAttr('disabled');
                $('.transfering').hide();
            }
            
        });


        });



    })

</script>
@endsection




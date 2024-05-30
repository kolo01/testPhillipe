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
                    <p class="text-center" style="font-size:2em;"> <span class="text-black">Approvisionner votre compte client <p>
                    <p class="text-center mb-3" style="font-size:1em;">Une fois que vous avez effectué un virement ou un dépôt de fonds sur un compte bancaire Bpay, veuillez nous en informer en renseignant ce formulaire. La preuve préférée est un avis de débit / avis Swift</p>
                    <form action="{{route('marchand.storedepot')}}" method="post" enctype="multipart/form-data">
                              @csrf
                        <div class="input-group margin-bottom-sm mb-2">
                            <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">F.CFA</span>
                            <input class="form-control" name="montant" id="amount" min="500" pattern="\d*" type="text" placeholder="Montant" style="background:#fff;border:1px solid #DDE6ED;">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">F.CFA</span>
                            <input class="form-control" name="confirm_montant" id="confirm_amount" pattern="\d*" min="500" type="text" placeholder="Confirmer le montant" style="background:#fff;border:1px solid #DDE6ED;">
                        </div>

                        <div class="input-group mb-2">
                            <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">Preuve de paiement (avis de débit/ avis Swift)</span>
                            <input class="form-control" name="payment_file" id="payment_file"  type="file"  style="background:#fff;border:1px solid #DDE6ED;" required>
                        </div>
                        <div class="form-group">
                            <button  class="btn btn-primary depot" type="submit"> <span class="transfering">Envoie en cours...<i class="fa fa-spinner fa-spin fa-fw"></i></span> <span class="initiate-depot">Valider <i class="fa fa-check-alt fa-fw" aria-hidden="true"></i></span> </button>
                            <a href="" class="btn btn-danger text-white" type="submit">Annuler</a>
                        </div> 
                    </form>
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
                       <h4 class="text-center">Liste des preuves de paiements</h4>
                    </div>
                    <table id="myTable" class="table" data-order='[[ 1, "desc" ]]'>
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Montant</th>
                                <th scope="col">Fichier</th>
                                <th scope="col">Date d'envoie</th>
                                <th scope="col">Statut</th>
                                @if(auth()->user()->role == "superAdmin")
                                <th scope="col">Actions</th>
                                @endif
                            </tr> 
                        </thead>
                        <tbody>
                           @foreach($depots as $depot)
                            <tr>
                                <td>{{$depot->montant_depot}} fcfa</td>
                                <td>
                                @if($depot->payment_file)
                                <span style="color:#000;">{{$depot->payment_file}}  </span>
                                <a  style="color:#000;" href="{{ asset('depotbanque/' . $depot->payment_file) }}" download="{{ $depot->payment_file }}"> <i class="fa fa-download"></i></a>
                                @else
                                    <p>Aucun fichier disponible.</p>
                                @endif
                                <td>{{date('d/mY H:i:s', strtotime($depot->created_at))}}</td>
                                <td>
                                    @if($depot->status == 'INITIATED') 
                                        <div class="_leads_status"><span class="active" style="background:#5499C7;color:#fff;">EN ATTENTE</span></div>
                                    @elseif($depot->status == 'FAILED') 
                                        <div class="_leads_status"><span class="active" style="background:red;color:#fff;">REFUSER</span></div>
                                    @elseif($depot->status == 'SUCCESS')
                                        <div class="_leads_status"><span class="active" style="background:green;color:#fff;">APPROUVER</span></div>
                                    @endif
                                </td>

                                @if(auth()->user()->role == "superAdmin")
                                <td>      
                               
                                      <a href="{{ route('marchand.validatedepot', ['id' => $depot->id]) }}" class="btn btn-sm btn-primary" title="Approuvé" onclick="return confirm('Êtes-vous sûr de vouloir confirmer le dépôt de {{$depot->montant_depot}} effectué le {{$depot->created_at}} par le marchand {{App\Models\Marchand::find($depot->marchand_id)->nom}}')"><i class="fas fa-check"></i></a>
                                      <a href="{{ route('marchand.canceldepot', ['id' => $depot->id]) }}" class="btn btn-sm btn-danger" title="Refusé" onclick="return confirm('Êtes-vous sûr de vouloir refuser le dépôt de {{$depot->montant_depot}} effectué le {{$depot->created_at}} par le marchand {{App\Models\Marchand::find($depot->marchand_id)->nom}}')"><i class="fas fa-times"></i></a>
                                  
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
    

    var amount = document.querySelector('#amount');
    var confirm_amount = document.querySelector('#confirm_amount');
    amount.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        this.value = formatNumberWithSeparator(this.value);
        console.log(this.value);
    });

    confirm_amount.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        this.value = formatNumberWithSeparator(this.value);
        console.log(this.value);
    });

    $(document).ready(function() {
        $('.transfering').hide();
        $('.depot').on('click', function(e) {
        e.preventDefault();

        if (amount.value != confirm_amount.value) {
            new swal({
                title: "Désolé !",
                text: "Le montant saisi doit être identique à la confirmation du montant.",
                icon: 'error',
                button: "Ok",
            });  

            return null;
        }
        
        if (!payment_file.value) {
            new swal({
                title: "Désolé !",
                text: "Vous devez importer le fichier qui confirme le dépôt à la banque",
                icon: 'error',
                button: "Ok",
            });

            return null;
        }

        $.ajax({
            method: $('form').attr('method'),
            url: $('form').attr('action'),
            data: new FormData($('form')[0]),
            processData:false,
            contentType:false,
            beforeSend: function() {
                // Code exécuté avant l'envoi de la requêtes
                $('.initiate-depot').hide();
                $('.transfering').show();
                $('.depot').attr('disabled', true);
            },
            success: function(data) {
                // Code exécuté en cas de succès de la requête
                console.log(data);
                $('.initiate-depot').show();
                $('.transfering').hide();
                if (data == 'succeeded') {
                    new swal({
                        title: "Félicitation!",
                        text: "Preuve de paiement envoyée avec succès",
                        icon: "success",
                        button: "Ok",
                    });
                    setTimeout(() => {
                        window.location.reload();
                        console.log('reload')
                    }, 3000);
                }else if (data == 'failed') {
                    new swal({
                        title: "Envoie de preuve de paiement échouée !",
                        text: "Veuillez vérifier le montant de la transaction.",
                        icon: 'error',
                        button: "Ok",
                    });  
                } 
                $('.depot').removeAttr('disabled');
    
            },
            error: function(xhr, status, error) {
                // Code exécuté en cas d'erreur de la requête 
                new swal({
                        title: "Désolé échec de l'envoie !",
                        text: "Veuillez ressayer car une erreur c'est produite.",
                        icon: "error",
                        button: "Ok",
                    }); 
                    $('.depot').removeAttr('disabled');
                    $('.transfering').hide();
            }
            
        });


        });



    })

    function formatNumberWithSeparator(number) {
            // Supprimer les espaces existants
            number = number.replace(/\s/g, '');
            // Ajouter le séparateur de milliers dès que le nombre atteint 1000
            if (parseInt(number) >= 1000) {
                return Number(number).toLocaleString('fr-FR');
            } else {
                return number;
            }
        }

</script>
@endsection




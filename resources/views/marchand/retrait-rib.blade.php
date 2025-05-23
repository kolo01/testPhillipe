@extends('layout')

@section('content')
    <div class="col-lg-9 col-md-8 mt-3">
        <div class="dashboard-body">
          @if(auth()->user()->role == "admin" || auth()->user()->role == "superAdmin")
            <div class="dashboard-wraper mb-5">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <!-- Information -->
                        <div class="card" style="color: #fff;background:#144273">
                            <h4 class="text-center text-white text-uppercase mt-2">Information Bancaire</h4>
                        </div>
                        <form action="/modifier-rib" method="post">
                            @csrf
                            @method('POST')
                            <div class="form-row d-flex align-items-center"> <!-- Flexbox ajouté ici -->

                                <!-- Champ de formulaire -->
                                <div class="form-group col-lg-12">
                                    <label>RIB Utilisé</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">
                                            <i class="ti-credit-card fa-lg" style="color:black;"></i>
                                        </span>
                                        <input type="text" id="rib" name="rib" class="form-control" value="{{ $marchand->rib }}">
                                    </div>
                                </div>

                                <!-- Bouton Modifier -->
                                <div class="form-group col-lg-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger text-white">
                                        <i class="ti-save fa-lg" style="color:white; margin-right:10px;"></i>
                                        Modifier
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="dashboard-wraper">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card" style="color: #fff;background:#144273">
                            <h4 class="text-center text-white text-uppercase mt-2">Demande de retrait</h4>
                        </div>
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">
                                <form action="/save-retrait" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="frm_submit_wrap">
                                        <div class="form-row">

                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Marchand </label>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">
                                                        <i class="ti-user fa-lg" style="color:black;"></i>
                                                    </span>
                                                    <input type="text" class="form-control"
                                                    value="{{ $marchand->nom }}" readonly>
                                                </div>
                                            </div>


                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Contact</label>

                                                    <div class="input-group mb-2">
                                                      <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">
                                                        <i class="ti-mobile fa-lg" style="color:black;"></i>
                                                      </span>
                                                      <input type="number" name="contact" class="form-control"
                                                      value="{{ $marchand ->contact }}" readonly>
                                                  </div>
                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Montant à retirer</label>

                                                <div class="input-group mb-2">
                                                  <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">F.CFA</span>
                                                  <input type="number" class="form-control" id="amount" name="amount" placeholder="0" >
                                              </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                  <i class="ti-money  fa-lg" style="color:white; margin-right:5px"></i> Lancer Retrait
                                </button>
                            </div>


                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation de retrait</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <center class="mt-2 mb-4"><Img src=" {{ asset('assets/img/image/logo/logo.png') }}" width="50px" height="50px" alt="logo Babimo"/></center>
                                   <div class="d-flex p-2 justify-content-between ">
                                    <p><strong>Initiateur :</strong></p>
                                    <p style="line-break: auto; word-wrap: break-word; width:200px "> {{ auth()->user()->username }}</p>
                                   </div>
                                   <div class="d-flex p-2 justify-content-between ">
                                    <p><strong>Marchand :</strong> </p>
                                    <p style="line-break: auto; word-wrap: break-word; width:200px ">{{ $marchand->nom  }}</p>
                                   </div>
                                    <div class="d-flex p-2 justify-content-between ">
                                      <p class="w-70"><strong>RIB Utilisé: </strong> </p>
                                      <p style="line-break: auto; word-wrap: break-word; width:200px ">{{ $marchand->rib }}</p>
                                    </div>
                                    <div class="d-flex p-2 justify-content-between ">

                                      <p><strong>Montant :</strong> </p>
                                      <p style="line-break: auto; word-wrap: break-word; width:200px "><span id="displayAmount"></span></p>
                                    </div>
                                  </div>
                                  <div class="modal-footer space-between">
                                    <button type="button" onclick="alert('Transaction Annulée')" class="btn btn-secondary" data-dismiss="modal"><i class="ti-close fa-lg" style="color:black; margin-right:20px"></i>Annuler</button>
                                    <button type="submit"  onclick="alert('Votre demande de retrait est en cours de validation!')" class="btn btn-danger ml-2 text-white"><i class="ti-check fa-lg" style="color:white; margin-right:20px"></i>Confirmer retrait</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            @endif
            <div class="row mt-5" >
              <div class="col-lg-12 col-md-12">
                  <div class="dashboard_property">
                      <div class="table-responsive">
                          <div class="col-md-12 mb-3">
                             <h4 class="text-center">Liste des demandes de retraits</h4>
                          </div>
                          <table id="myTable" class="table" data-order='[[ 2, "desc" ]]'>
                              <thead class="thead-dark">
                                  <tr>
                                      <th scope="col">Initié par</th>
                                      <th scope="col">Montant à retiré</th>
                                      <th scope="col">Date de la demande</th>
                                      <th scope="col">Status de la demande</th>
                                      @if(auth()->user()->role == "superAdmin")
                                       <th scope="col">Actions</th>
                                      @endif
                                  </tr>
                              </thead>
                              <tbody>
                                 @foreach($allTransacation as $transacation)

                                  <tr>
                                      <td>{{json_decode($transacation->trace)[0]}}</td>
                                      <td>{{$transacation->amount}}  fcfa</td>


                                      {{-- <td>{{intval($transacation->createdAt)}}</td> --}}
                                      <td>{{date('d/m/Y H:i:s', strtotime($transacation->createdAt))}}</td>


                                      <td>
                                          @if($transacation->status == 'EN COURS')
                                              <div class="_leads_status"><span class="active" style="background:#5499C7;color:#fff;">{{$transacation->status}}</span></div>
                                          @elseif($transacation->status == 'ECHOUE')
                                              <div class="_leads_status"><span class="active" style="background:red;color:#fff;">{{$transacation->status}}</span></div>
                                          @elseif($transacation->status == 'SUCCES')
                                              <div class="_leads_status"><span class="active" style="background:green;color:#fff;">{{$transacation->status}}</span></div>
                                          @endif
                                      </td>

                                      @if(auth()->user()->role == "superAdmin")
                                      <td>
                                          @if($transacation->status  == 'EN COURS')
                                            <a href="{{ route('transfert.rib', ['id' => $transacation->id]) }}" class="btn btn-sm btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir confirmer le retrait de {{$transacation->amount}} demandé par le marchand {{\App\Models\Marchand::find($transacation->marchand_id)->nom}}  ?');"><i class="fas fa-check"></i></a>
                                            <a href="{{ route('transfert.ribcancel', ['id' => $transacation->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler le retrait de {{$transacation->amount}} demandé par le marchand {{\App\Models\Marchand::find($transacation->marchand_id)->nom}}?');"><i class="fas fa-times"></i></a>
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



          <!-- Button trigger modal -->


<!-- Modal -->




        </div>

        <script>
          // Mettre à jour le champ "Nom" en temps réel
          document.getElementById('amount').addEventListener('input', function () {
              document.getElementById('displayAmount').textContent = this.value;
          });

          Submitted(){
            alert("hello!");
          }

      </script>
    @endsection

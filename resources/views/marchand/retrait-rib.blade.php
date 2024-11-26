@extends('layout')

@section('content')
    <div class="col-lg-9 col-md-8 mt-3">
        <div class="dashboard-body">
          @if(auth()->user()->role == "admin")
            <div class="dashboard-wraper mb-5">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">
                                <h3 class="text-center">Information Bancaire</h3><br>
                                <form action="/modifier-rib" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="frm_submit_wrap">
                                        <div class="form-row">

                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>RIB Utilisé</label>
                                                <input type="text" id="rib" name="rib" class="form-control"
                                                    value="{{ $marchand->rib }}">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button type="submit" class="btn btn-danger ml-2 text-white">Modifier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="dashboard-wraper">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">
                                <h3 class="text-center">Demande de retrait</h3><br>
                                <form action="/save-retrait" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="frm_submit_wrap">
                                        <div class="form-row">

                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Nom & Prénoms </label>
                                                <input type="text" class="form-control" value="{{ $marchand->nom }}"
                                                    readonly>
                                            </div>


                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Contact</label>

                                                    <div class="input-group mb-2">
                                                      <span class="input-group-addon" style="border:1px solid #DDE6ED;font-weight:bold;">Numéro</span>
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
                                  Lancer Retrait
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
                                   <div class="d-flex p-2 justify-content-around ">
                                    <p><strong>Initiateur :</strong> {{ auth()->user()->username }}</p>
                                    <p><strong>Marchand :</strong> {{ $marchand->nom  }}</p>

                                   </div>
                                    <div class="d-flex p-2 justify-content-around ">
                                      <p><strong>RIB Utilisé :</strong> {{ $marchand->rib }}</p>
                                      <p><strong>Montant :</strong> <span id="displayAmount"></span></p>
                                    </div>

                                  </div>
                                  <div class="modal-footer space-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger ml-2 text-white">Confirmer retrait</button>
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
                                      {{-- <th scope="col">Montant perçu</th>
                                      <th scope="col">Frais</th> --}}
                                      <!-- <th scope="col">Montant restant</th> -->
                                      <th scope="col">Date de la demande</th>
                                      <th scope="col">Status de la demande</th>
                                      {{-- <th scope="col">Mode de paiement</th> --}}
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


      </script>
    @endsection

@extends('layout')
@section('content') 
    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="dashboard-body">
            <div class="clearfix mb-3"></div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <form action="{{route('search.transactions')}}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="id_paie">TRANSACTION ID</label>
                                <input type="text" name="id_paie" placeholder="Rechercher par un identifiant de transaction" class="form-control" id="transaction">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Statut</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Choisir</option>
                                    <option value="PENDING">EN ATTENTE</option>
                                    <option value="SUCCESS">SUCCES</option>
                                    <option value="FAILED">ECHOUE</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="modepaiement">Opérateur</label>
                                <select name="modepaiement" id="modepaiement" class="form-control">
                                    <option value="">Choisir</option>
                                    <option value="OM_CI">Orange Money</option>
                                    <option value="WAVE_CI">WAVE</option>
                                    <option value="MTN_CI">MTN Momo</option>
                                    <option value="MOOV_CI">Moov</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Choisir</option>
                                    <option value="retrait">Retrait</option>
                                    <option value="depot">Paiement</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="periode_debut">Date début</label>
                                <input type="date" class="form-control" id="periode_debut" name="periode_debut">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="periode_fin">Date fin</label>
                                <input type="date" class="form-control" id="periode_fin" name="periode_fin">
                            </div>
                            <div class="form-group col-md-4 align-self-end">
                                <button type="submit" class="btn btn-primary btn-block">Rechercher</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="p-2 border bg-light">      
                                    <p class="text-center" style="color:#3498DB;font-weight:bolder;font-size:100%;text-transform:uppercase;">
                                        Nombre de Transaction: {{$totalTransactions}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{route('export.excel')}}" method="post">
                        @csrf
                        <div class="form-row mt-3">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="results" value="{{json_encode($transactions)}}">
                                <button type="submit" class="btn btn-success btn-block"> <i class="fas fa-file-excel" style="color: #fff"></i> Exporter le document </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="dashboard_property">
                        <div class="table-responsive overflow-auto" style=" overflow: auto;">
                            <table class="table table-responsive overflow-auto" id="myTable" data-order-test='[[ 1, "desc" ]]'>
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Opérateur</th>
                                    <th scope="col">Marchand</th>
                                    <th scope="col">Mode paiement</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="m2_hide">Description</th>
                                    <th scope="col">Tel.</th>
                                    <th scope="col" class="m2_hide">Montant</th>
                                    <th scope="col">Frais</th>
                                    <th scope="col" class="">Type</th>
                                    <th scope="col" class="m2_hide">Statut</th>
                                    <th scope="col" class="m2_hide">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="m2_hide">
                                            <div class="prt_leads"><span>{{$i++}}</span></div>
                                        </td>
                                        <td>
                                            <div class="dash_prt_wrap">
                                                <div class="dash_prt_thumb">
                                                   @if($transaction->modepaiement == "OM_CI")
                                                        <img src="{{ asset('assets/img/image/operateurs/orange.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                                    @endif

                                                    @if($transaction->modepaiement == "WAVE_CI")
                                                        <img src="{{ asset('assets/img/image/operateurs/wave.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                                    @endif

                                                    @if($transaction->modepaiement == "MTN_CI")
                                                        <img src="{{ asset('assets/img/image/operateurs/mtn.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                                    @endif

                                                    @if($transaction->modepaiement == "MOOV_CI")
                                                        <img src="{{ asset('assets/img/image/operateurs/moov.jpg') }}" width="100%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="m2_hide">{{$transaction->marchand_nom ?? ""}}</td>
                                        <td class="m2_hide">
                                            <div class="prt_leads">
                                                
                                                     @if($transaction->modepaiement == "OM_CI")
                                                     <span>{{"Orange Money"}}</span>
                                                    @endif

                                                    @if($transaction->modepaiement == "WAVE_CI")
                                                    <span>{{"Wave"}}</span>
                                                    @endif

                                                    @if($transaction->modepaiement == "MTN_CI")
                                                      <span>{{"MTN Momo"}}</span>
                                                    @endif

                                                    @if($transaction->modepaiement == "MOOV_CI")
                                                    <span>{{"Moov"}}</span>
                                                    @endif
                                            </div>
                                        </td>
                                        @php
                                        $montant = $transaction->transacmontant;
                                        $fraistransaction = $transaction->fraistransaction;
                                        $frais = floatval($fraistransaction) * $montant * 1/100;
                                        $montant_paye = $montant - $frais;
                                        $montant_retrait = $montant + $frais;
                                        $montant = $transaction->type == 'retrait' ? $montant_retrait : $montant_paye;
                                        $type = $transaction->type == 'retrait' ? "Retrait" : "Paiement";
                                        $id_transac = base64_encode($transaction->merchant_transaction_id);
                                        $tel = $transaction->type == "retrait" ? App\Models\RetraitMarchand::where('notif_token',$transaction->merchant_transaction_id)->first()->telephone ?? "" : \DB::table('info_transactions')->where('transaction_order_id', $transaction->merchant_transaction_id)->first()->client_phone ?? "";
                                        @endphp
                                        <td class="m2_hide">
                                            <div class="prt_leads"><span>{{date('d/m/Y H:i:s', strtotime($transaction->created_at))}}</span></div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="prt_leads"><span>Reçu du référent client: {{$transaction->merchant_transaction_id}}</span></div>
                                        </td>
                                        <td class="m2_hide">{{$tel}}</td>
                                        <td class="m2_hide"> 
                                            <div class="_leads_view_title" class="text-truncate">
                                                <span>
                                                 {{$transaction->type == 'retrait' ? "-" : ""}}@if(isset($montant)){{number_format($montant, 0, ' ', ' ')}} @else {{$montant ?? ""}} @endif xof
                                                </span>
                                            </div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="prt_leads">{{$frais}}</div>
                                        </td>
                                        <td class="m2_hide">
                                            <span class="text-truncate" style="background:#d2e259;color:#fff;padding:5px;">  {{$type}}</span>
                                        </td> 
                                        <td class="m2_hide">
                                            <div class="_leads_view_title">
                                              @if ($transaction->statut == 'INITIATE' || $transaction->statut == 'INITIATED' || $transaction->statut == 'PENDING' || $transaction->statut == 'processing' )
                                                <span class="text-truncate" style="background:#2039c7;color:#fff;padding:5px;"> En attente</span>
                                              @elseif($transaction->statut == 'SUCCEEDED' || $transaction->statut == 'SUCCESS' || $transaction->statut == 'SUCCES' || $transaction->statut == 'VALIDED')
                                                <span style="background:#52BE80;color:#fff;padding:5px;"> Succès</span>
                                              @elseif($transaction->statut == 'FAILED' || $transaction->statut == 'EXPIRED' || $transaction->statut == 'cancelled')
                                                <span style="background:#E74C3C;color:#fff;padding:5px;"> Echoué</span>
                                              @endif
                                            </div>
                                        </td> 
                                        <td class="text-truncate">
                                            <a title="Voir le détail des transactions" href="{{route('detail.transaction', $id_transac)}}" style="background:#3498DB;border-color:#3498DB;color:#fff;" class="btn btn-sm btn-secondary">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </td> 
                                
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
            
    </div>
@endsection

<div class="dashboard_property listetransaction chargement text-center justify-content-center">
    <div class="table-responsive overflow-auto" style=" overflow: auto;">
        <table class="table table-responsive overflow-auto" id="myTable" data-order-test='[[ 1, "desc" ]]'>
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Opérateur</th>
                <th scope="col">Marchand</th>
                <th scope="col">Mode.P</th>
                <th scope="col">Date</th>
                <th scope="col" class="m2_hide">Desc.</th>
                <th scope="col">Tel.</th>
                <th scope="col" class="m2_hide">Montant</th>
                <th scope="col">Frais</th>
                <th scope="col" class="">Type</th>
                <th scope="col" class="m2_hide">Statut</th>
                <th scope="col" class="m2_hide">Action</th>
                </tr>
            </thead>
            <tbody class="listetransaction chargement">
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
        <div class="row col-md-12 justify-content-center"> {{$transactions->links()}}</div> 

    </div>
</div>



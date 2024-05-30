@extends('layout')
<style>


        table {
            width: 100%;
            background: #fff;
        }

        table, th, td {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #5499C7;
            color: #fff;
        }
</style>
@section('content') 
    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="dashboard-body">
            <div class="clearfix mb-4"></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-2">
               
                        <h4 class="text-center mb-3">Informations de la transaction</h4>
                        <table class="mb-4">
                            <tr>
                                <th>Champ</th>
                                <th>Valeur</th>
                            </tr>
                            <tr>
                                <td>Montant</td>
                                <td>@if($infotransaction->montantmarchand){{number_format($infotransaction->montantmarchand, 0, ' ', ' ')}} @else {{$infotransaction->montantmarchand}} @endif xof</td>
                            </tr>
                            <tr>
                                <td>Mode de paiement</td>
                                <td>
                                 
                                    @if($infotransaction->modepaiement == "OM_CI")
                                        <img src="{{ asset('assets/img/image/operateurs/orange.jpg') }}" width="5%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                    @endif

                                    @if($infotransaction->modepaiement == "WAVE_CI")
                                        <img src="{{ asset('assets/img/image/operateurs/wave.jpg') }}" width="5%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                    @endif

                                    @if($infotransaction->modepaiement == "MTN_CI")
                                        <img src="{{ asset('assets/img/image/operateurs/mtn.jpg') }}" width="5%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                    @endif

                                    @if($infotransaction->modepaiement == "MOOV_CI")
                                        <img src="{{ asset('assets/img/image/operateurs/moov.jpg') }}" width="5%;" style="border: 2px solid #e5e5e5; border-radius: 0.25rem;" alt="" srcset="">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>ID de la transaction</td>
                                <td>
                                <div>
                                    <div style="width: 50%; float: left;">
                                        ID: {{$infotransaction->merchant_transaction_id}}
                                    </div>
                                    <div style="width: 50%; float: left;">
                                      Statut: 
                                        @if ($infotransaction->statut == 'INITIATE' || $infotransaction->statut == 'INITIATED' || $infotransaction->statut == 'PENDING' || $infotransaction->statut == 'processing' )
                                        <span class="text-truncate" style="background:#52BE80;color:#fff;padding:5px;"> En cours</span>
                                        @elseif($infotransaction->statut == 'SUCCEEDED' || $infotransaction->statut == 'SUCCESS' || $infotransaction->statut == 'SUCCES' || $infotransaction->statut == 'VALIDED')
                                        <span style="background:#52BE80;color:#fff;padding:5px;"> Succès</span>
                                        @elseif($infotransaction->statut == 'FAILED' || $infotransaction->statut == 'EXPIRED' || $infotransaction->statut == 'cancelled')
                                        <span style="background:#E74C3C;color:#fff;padding:5px;"> Echoué</span>
                                        @endif
                                    </div>
                                </div>
                                </td>
                            </tr>

                        </table>
                        <h4 class="text-center mb-3">Autres informations relatives à la transaction</h4>
                        <table>
                            <tr>
                                <th>Champ</th>
                                <th>Valeur</th>
                            </tr>
                            <tr>
                                <td>Montant</td>
                                <td>@if(isset($autresinfo->amount) && !empty($autresinfo->amount)){{number_format($autresinfo->amount, 0, ' ', ' ')}} @else {{" "}} @endif xof</td>
                            </tr>
                            <tr>
                                <td>ID de la transaction</td>
                                <td>
                                <div>
                                    <div style="width: 50%; float: left;">
                                        ID: {{$autresinfo->transaction_order_id ?? ""}}
                                    </div>
                                    <div style="width: 50%; float: left;">
                                      parcelUID: {{$autresinfo->parcelUID ?? ""}}
                                    </div>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nom</td>
                                <td>{{$autresinfo->nom ?? ""}}</td>
                            </tr>
                            <tr>
                                <td>Prénoms</td>
                                <td>{{$autresinfo->prenoms ?? ""}}</td>
                            </tr>
                            <tr>
                                <td>Numero de téléphone</td>
                                <td>{{$autresinfo->phoneNumber ?? ""}}</td>
                            </tr>
                        </table>
                </div>
              
                <div class="col-lg-12 col-md-12">
                    <a title="Consulter les détails de la transaction" href="{{route('liste.transactions')}}" style="background:#3498DB;border-color:#3498DB;color:#fff;" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Retour
                    </a>
                </div>
            </div> 

            <!-- row -->       
        </div>
            
    </div>
@endsection

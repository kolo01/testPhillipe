@extends('layout')

@section('content')       
    <div class="col-lg-9 col-md-8">
        <div class="dashboard-body">
        
            <div class="clearfix mb-3"></div>
        
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
    
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dashboard_stats_wrap widget-3">
                        <div class="dashboard_stats_wrap_content"><h5>{{$transactions}}</h5> <span>Transactions</span></div>
                        <div class="dashboard_stats_wrap-icon"><i class="ti-credit-card"></i></div>
                    </div>	
                </div>

                    
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dashboard_stats_wrap widget-1">
                        <div class="dashboard_stats_wrap_content"><h5>{{$total_success}}</h5> <span>Total succès</span></div>
                    </div>	
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dashboard_stats_wrap widget-2">
                        <div class="dashboard_stats_wrap_content"><h5>{{$total_failed}}</h5> <span>Total échecs</span></div>
                    </div>	
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dashboard_stats_wrap widget-4">
                        <div class="dashboard_stats_wrap_content"><h5> @if($montant_total){{number_format($montant_total, 0, ' ', ' ')}} @else {{$montant_total}} @endif xof</h5> <span>Montant total</span></div>
                        <div class="dashboard_stats_wrap-icon"><i class="ti-wallet"></i></div>
                    </div>	
                </div>

            </div>
            <!-- Liste des opérateurs -->
          <!--  <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Information</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-lg table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Montant</th>
                                            <th class="text-truncate">Identifiant de transaction</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <tr>
                                            <td>11/05/2023 12:04</td>
                                            <td>Reçu de Konan Amoin Celine 07 89 24 2437 par Checkout API - référence client: PAIE-VCvJjy4Iix00192</td>
                                            <td>85 F</td>
                                            <td>T_CPIDUMFTTU</td>                
                                            <td class="text-truncate">
                                                <a href="" class="btn btn-sm btn-secondary" onclick="return ('')">Rembourser</a>
                                                <a href="" data-toggle="modal" data-target="#detailTransac-marchand" class="btn btn-sm btn-secondary">Détail</a>
                                            </td>                                        
                                        </tr>                                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- /Liste des opérateurs -->
            <!--  Statistique des transactions par réseaux -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Statistique des transactions</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-inline text-center m-t-30">
                                <li>
                                    <h5><i class="fa fa-circle m-r-5 orange"></i>Orange </h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5 mtn"></i>MTN</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5 moov"></i>Moov</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5 wave"></i>Wave</h5>
                                </li>
                            </ul>
                            <div id="tester" style="width:1000px;height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>    
            <!-- row -->
            
        
        </div>
    </div>  
@endsection

 

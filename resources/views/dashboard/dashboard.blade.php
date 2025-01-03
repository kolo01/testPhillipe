@extends('layout')

@section('content')   
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto);

body {
font-family: Roboto, sans-serif;
}

#chart {
max-width: 650px;
margin: 35px auto;
}
</style>      
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
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                @php
                                    $hour = date('H');
                                    $greeting = ($hour < 12) ? 'Bonjour' : 'Bonsoir';
                                @endphp
                                <strong>{{$greeting}} M/Mme {{auth()->user()->username}}</strong>, ce graphique affiche les transactions des <strong>30 derniers jours</strong>.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>  
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
                            <div id="paychart"></div>
                            {{-- <div id="retchart"></div> --}}
                        </div>
                    </div>
                </div>
            </div>    
            <!-- row -->
            
        
        </div>
    </div>  

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

var mapData = @json($mapData);
var dep = mapData.dep;
//var ret = mapData.ret;
var p = [];
//var r = [];
var dp = [];
//var dr = [];
dep.forEach(function(item) {
    p.push(item.transaction_count);
    dp.push(item.date);
});
/*
ret.forEach(function(item) {
    r.push(item.transacmontant);
    dr.push(item.date);
}); */
console.log('===================Tableau P=================')
console.log(p);
console.log('--------------------------------------------------')
console.log(dp);
console.log('===================Fin Tableau P=================')
console.log('===================Tableau R=================')
//console.log(r);
console.log('--------------------------------------------------')
//console.log(dr);
console.log('=====================Fin Tableau R==============')
var payOptions = {
        chart: {
            height: 350,
            type: "line",
            stacked: false
        },
        dataLabels: {
            enabled: false
        },
        colors: ["#247BA0", "#247BA0"],
        series: [
            {
            name: "Transaction",
            data: p
            }
        ],
        stroke: {
            width: [4, 4]
        },
        plotOptions: {
            bar: {
            columnWidth: "20%"
            }
        },
        xaxis: {
            categories: dp
        },
        yaxis: [
            {
            axisTicks: {
                show: true
            },
            axisBorder: {
                show: true,
                color: "#247BA0"
            },
            labels: {
                style: {
                colors: "#247BA0"
                }
            },
            title: {
                text: "NOMBRE DE TRANSACTION (jOUR)",
                style: {
                color: "#247BA0"
                }
            }
            },
        ],
        tooltip: {
            shared: false,
            intersect: true,
            x: {
            show: false
            }
        },
        legend: {
            horizontalAlign: "left",
            offsetX: 40
        }
    };

var payChart = new ApexCharts(document.querySelector("#paychart"), payOptions);

payChart.render();

    </script>

@endsection

 

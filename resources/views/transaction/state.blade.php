@extends('layout')
@section('content')
    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="dashboard-body">

        </div>
        <div class="clearfix mb-3"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <form action="{{ route('liste.statistiqueSearch') }}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="periode_debut">Date début</label>
                            <input type="date" class="form-control"
                                value="{{ $periodeDebut ? date('Y-m-d', strtotime($periodeDebut)) ?? '' : '' }}"
                                id="periode_debut" name="periode_debut">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="periode_fin">Date fin</label>
                            <input type="date" class="form-control" id="periode_fin"
                                value="{{ $periodeFin ? date('Y-m-d', strtotime($periodeFin)) ?? '' : '' }}"
                                name="periode_fin">
                        </div>
                        @if (auth()->user()->role == 'superAdmin')
                            <div class="form-group col-md-3">
                                <label for="periode_fin">Marchand</label>
                                <select class="form-control" id="marchand_selected" name="marchand_selected">
                                    <option value=""></option>
                                    @foreach ($allMarchand as $marchand)
                                        <option value="{{ $marchand->id }}">{{ $marchand->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary btn-block">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="dashboard_property">

                    <div class="card">
                        <div class="card-body">

                            @if ($marchandFounded != null)
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">

                                    Historique du marchand <strong> {{ $marchandFounded->nom }}</strong>.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            @if (Route::currentRouteName() == 'liste.statistique')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    @php
                                        $hour = date('H');
                                        $greeting = $hour < 12 ? 'Bonjour' : 'Bonsoir';
                                    @endphp
                                    <strong>{{ $greeting }} M/Mme {{ auth()->user()->username }}</strong>, par défaut
                                    les transactions suivantes sont celles du jour.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Nombre de transaction
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            {{ $nb_t }}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 mb-3">
                                                    <div class="p-3 border bg-light">
                                                        Solde
                                                        <hr>
                                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                                           @if ($solde)
    {{ number_format($solde, 0, ' ', ' ') }}
@else
    {{ $solde }}
    @endif
                                                        </p>
                                                    </div>
                                                </div> -->
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Montant reçu
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            @if ($sum_paye)
                                                {{ number_format($sum_paye, 0, ' ', ' ') }}
                                            @else
                                                {{ $sum_paye }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Montant retiré
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            @if ($sum_retire)
                                                {{ number_format($sum_retire, 0, ' ', ' ') }}
                                            @else
                                                {{ $sum_retire }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Frais
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            @if ($feesAmount)
                                                {{ number_format($feesAmount, 0, ' ', ' ') }}
                                            @else
                                                {{ $feesAmount }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Transactions en attente
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            @if ($trans_pending)
                                                {{ $trans_pending }}
                                            @else
                                                0
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 border bg-light">
                                        Montant en attente
                                        <hr>
                                        <p class="text-center" style="color:#3498DB;font-weight:bold;">
                                            @if ($sum_pending)
                                                {{ $sum_pending }}
                                            @else
                                                0
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

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




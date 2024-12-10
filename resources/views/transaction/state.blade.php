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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>

    </div>
@endsection

@extends('layout')

@section('content')

<div class="col-lg-9 col-md-8 col-sm-12 mt-3">
    <div class="dashboard-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="_prt_filt_dash">
                    <div class="_prt_filt_dash_flex">
                        <div class="foot-news-last">
                             <p class="text-bold" style="font-weight: bold;font-size:18px;color:black;">Total: {{$total ?? ''}}</p>
                        </div>
                    </div>
                    <div class="_prt_filt_dash_last m2_hide">
                        <div class="_prt_filt_radius">
                            
                        </div>
                        <div class="_prt_filt_add_new">
                            <a href="{{route('marchand.ajouter')}}" class="prt_submit_link"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-block d-md-block"> Nouveau marchand</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="dashboard_property">
                    <div class="table-responsive">
                        <table id="myTable" class="table" data-order='[[ 1, "desc" ]]'>
                            <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Marchand</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Action</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <!-- tr block -->
                                @foreach($marchands as $marchand)
                                    <tr>
                                        <td>
                                            <div class="dash_prt_wrap">
                                                <div class="dash_prt_thumb">
                                                    @if (isset($marchand->piece_identite) && $marchand->piece_identite != "")
                                                    <img src="{{asset('bpay/public/uploads/'.$marchand->piece_identite)}}" width="80%" class="img-fluid" alt="{{$marchand->piece_identite}}" /> 
                                                    @else
                                                    <img src="{{asset('assets/img/image/house.jpg')}}" width="80%" class="img-fluid" alt="" />  
                                                    @endif
                                                </div>
                                                <div class="dash_prt_caption">
                                                    <h5>{{ $marchand->nom}}</h5>
                                                    <div class="prt_dash_rate"><span>Activité: </span>{{ $marchand->infobusiness}}</div>
                                                    <div class="prt_dash_rate"><span>Contact: </span>{{ $marchand->contact}}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="_leads_status"><span class="active">Active</span></div>
                                        </td>
                                        <td>
                                            <div class="_leads_action">
                                            <a href="{{ route('marchand.supprimer', ['sup' => $marchand->id]) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce marchand ?');"><i class="fas fa-trash"></i></a>
                                            <a href="{{ route('marchand.modifier', ['id' => $marchand->id]) }}" class="sendformId"><i class="fas fa-edit"></i></a>
                                            </div>
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
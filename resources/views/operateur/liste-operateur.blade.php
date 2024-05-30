@extends('layout')

@section('content')
						
<div class="col-lg-9 col-md-8 col-sm-12 mt-3">
    <div class="dashboard-body">
    
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="_prt_filt_dash">
                    <div class="_prt_filt_dash_flex">
                        <div class="foot-news-last">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Rechercher un operateur">
                                <div class="input-group-append">
                                    <span type="button" class="input-group-text theme-bg b-0 text-light"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_prt_filt_dash_last m2_hide">
                        <div class="_prt_filt_radius">
                            
                        </div>
                        <div class="_prt_filt_add_new">
                            <a href="/ajouter-un-operateur-pays" class="prt_submit_link"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-block d-md-block"> Nouveau operateur</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="dashboard_property">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Operateur</th>
                                  <th scope="col">Devise</th>
                                  <th scope="col">Pays</th>
                                  <th scope="col"></th>
                                </tr> 
                            </thead>
                            <tbody>
                                <!-- tr block -->
                                <tr>
                                    <td>
                                        <div class="dash_prt_wrap">
                                            <div class="dash_prt_thumb">
                                                <img src="{{asset('assets/img/image/operateurs/wave.jpg')}}" width="80%" class="img-fluid" alt="" />
                                            </div>
                                            <div class="dash_prt_caption">
                                                <h5>Wave</h5>
                                                <div class="prt_dash_rate"><span>Code pays: </span>CI</div>
                                                <div class="prt_dash_rate"><span>Payment method: </span>WAVE_CI</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>XOF</td>
                                    <td>Cote d'Ivoire</td>
                                    <td>
                                        <div class="_leads_action">
                                            <a href="#" data-toggle="modal" data-target="#delete-operateur"><i class="fas fa-trash"></i></a>
                                            <a href="/modifier-un-operateur-pays"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        <div class="dash_prt_wrap">
                                            <div class="dash_prt_thumb">
                                                <img src="{{asset('assets/img/image/operateurs/orange.jpg')}}" width="80%" class="img-fluid" alt="" />
                                            </div>
                                            <div class="dash_prt_caption">
                                                <h5>Orange</h5>
                                                <div class="prt_dash_rate"><span>Code pays: </span>CI</div>
                                                <div class="prt_dash_rate"><span>Payment method: </span>OM_CI</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>XOF</td>
                                    <td>Cote d'Ivoire</td>
                                    <td>
                                        <div class="_leads_action">
                                            <a href="#" data-toggle="modal" data-target="#delete-operateur"><i class="fas fa-trash"></i></a>
                                            <a href="/modifier-un-operateur-pays"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>      
                                <tr>
                                    <td>
                                        <div class="dash_prt_wrap">
                                            <div class="dash_prt_thumb">
                                                <img src="{{asset('assets/img/image/operateurs/mtn.jpg')}}" width="80%" class="img-fluid" alt="" />
                                            </div>
                                            <div class="dash_prt_caption">
                                                <h5>MTN</h5>
                                                <div class="prt_dash_rate"><span>Code pays: </span>CI</div>
                                                <div class="prt_dash_rate"><span>Payment method: </span>MTN_CI</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>XOF</td>
                                    <td>Cote d'Ivoire</td>
                                    <td>
                                        <div class="_leads_action">
                                            <a href="#" data-toggle="modal" data-target="#delete-operateur"><i class="fas fa-trash"></i></a>
                                            <a href="/modifier-un-operateur-pays"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>      
                                <tr>
                                    <td>
                                        <div class="dash_prt_wrap">
                                            <div class="dash_prt_thumb">
                                                <img src="{{asset('assets/img/image/operateurs/moov.jpg')}}" width="80%" class="img-fluid" alt="" />
                                            </div>
                                            <div class="dash_prt_caption">
                                                <h5>MOOV</h5>
                                                <div class="prt_dash_rate"><span>Code pays: </span>CI</div>
                                                <div class="prt_dash_rate"><span>Payment method: </span>MOOV_CI</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>XOF</td>
                                    <td>Cote d'Ivoire</td>
                                    <td>
                                        <div class="_leads_action">
                                            <a href="#" data-toggle="modal" data-target="#delete-operateur"><i class="fas fa-trash"></i></a>
                                            <a href="/modifier-un-operateur-pays"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>                     
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
@extends('layout')

@section('content')        
    <div class="col-lg-9 col-md-8">
        <div class="dashboard-body">
            <div class="clearfix mb-3"></div>
            <!-- Liste des opérateurs -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Opérateurs</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-lg table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Logo</th>
                                            <th>Opérateur</th>
                                            <th>Nbre Transaction</th>
                                            <th>Montant</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><a href="dashboard.html#"><img src="assets/img/image/operateurs/orange.jpg" class="avatar avatar-70 mr-2" alt="Avatar"></a></td>
                                            <td>Orange</td>
                                            <td>17</td>                
                                            <td>xof 310 000</td>
                                            <td><a href="" class="btn btn-sm btn-secondary">Détail</a></td>  
                                        </tr>   
                                        <tr>
                                            <td>2</td>
                                            <td><a href="dashboard.html#"><img src="assets/img/image/operateurs/mtn.jpg" class="avatar avatar-70 mr-2" alt="Avatar"></a></td>
                                            <td>MTN</td>
                                            <td>17</td>                
                                            <td>xof 310 000</td>
                                            <td><a href="" class="btn btn-sm btn-secondary">Détail</a></td>  
                                        </tr>   
                                        <tr>
                                            <td>3</td>
                                            <td><a href="dashboard.html#"><img src="assets/img/image/operateurs/moov.jpg" class="avatar avatar-70 mr-2" alt="Avatar"></a></td>
                                            <td>Moov</td>
                                            <td>17</td>                
                                            <td>xof 310 000</td>
                                            <td><a href="" class="btn btn-sm btn-secondary">Détail</a></td>  
                                        </tr> 
                                        <tr>
                                            <td>4</td>
                                            <td><a href="dashboard.html#"><img src="assets/img/image/operateurs/wave.jpg" class="avatar avatar-70 mr-2" alt="Avatar"></a></td>
                                            <td>Wave</td>
                                            <td>17</td>                
                                            <td>xof 310 000</td>
                                            <td><a href="/operateur-detail-transactions" class="btn btn-sm btn-secondary">Détail</a></td>  
                                        </tr>                                                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Liste des opérateurs -->
        </div>
    </div>  
@endsection

 

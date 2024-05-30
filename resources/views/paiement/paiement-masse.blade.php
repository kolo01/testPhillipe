@extends('layout')

@section('content')
    <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="dashboard-body">
            <div class="clearfix mb-3"></div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="_prt_filt_dash">
                        <div class="form-group ml-2">
                            <input type="text" name="transction" style="width:25em;"  placeholder="Rechercher par un identifiant de transaction" class="form-control" id="">
                        </div>
                        <div class="form-group ml-2">
                            <select name="operateur" id="operateur" class="form-control" style="width:12em;">
                                 <option value="28"> Choisir opérateur</option>
                                 <option value="28">Orange</option>
                                 <option value="28">MTN</option>
                                 <option value="45">Moov</option>
                                 <option value="13">Wave</option>
                            </select>
                        </div>
                        <div class="form-group ml-2">
                            <input type="date" name="" class="form-control" placeholder="Date début" id="">
                        </div>
                        <div class="form-group ml-2">
                            <input type="date" name="" class="form-control" placeholder="Date début" id="">
                        </div>
                        <button type="submit" class="btn btn-md btn-secondary ml-2 mb-2">Ok</button>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="dashboard_property">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="m2_hide">Description</th>
                                    <th scope="col" class="m2_hide">Montant</th>
                                    <th scope="col" class="m2_hide text-truncate">Identifiant de transaction</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- tr block -->
                                    <tr>
                                        <td>
                                            <div class="dash_prt_wrap">
                                                <div class="dash_prt_thumb">
                                                    <img src="assets/img/image/operateurs/orange.jpg" class="img-fluid" alt="" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="prt_leads"><span>11/05/2023</span></div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="prt_leads"><span>Reçu de BOHUI FRED HAROLD 05 66 39 3051 par Checkout API - référence client: PAIE-gLof6PXqyT00201</span></div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="_leads_view_title class="text-truncate""><span>100 000F</span></div>
                                        </td>
                                        <td class="m2_hide">
                                            <div class="_leads_view_title"><span>T_4JNZI5CJ64</span></div>
                                        </td>
                                        <td class="text-truncate">
                                        
                                            <a href="#" class="btn btn-sm btn-secondary">Rembourser</a>
                                            <a data-toggle="modal" data-target="#detailTransac-marchand" href="#" class="btn btn-sm btn-secondary">Détail</a>
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
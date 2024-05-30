@extends('layout')

@section('content')
<div class="col-lg-9 col-md-8 mt-3">
    <div class="dashboard-body">
        <!-- row -->
        <div class="dashboard-wraper">
            <div class="row">
                <!-- Submit Form -->
                <div class="col-lg-12 col-md-12">
                    <form action="" method="post">
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">	
                                <h3 class="text-center">Ajouter un nouveau operateur</h3><br>
                                <div class="frm_submit_wrap">
                                    <div class="form-row">
                                    
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Nom de l'opérateur</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Code pays </label>
                                            <input type="text" name="country_code" class="form-control">
                                        </div>
                                    
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                            <label>Payment method</label>
                                            <input type="text" name="currency" class="form-control">
                                        </div>
    
                                        <div class="form-group col-lg-4 col-md-4">
                                            <label>Currency</label>
                                            <input type="text" name="currency" class="form-control">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4">
                                            <label>Pays</label>
                                            <input type="country" name="country" class="form-control">
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                                <a href="/liste-operateurs-pays" class="btn btn-danger ml-2 text-white" type="submit">Annuler & Retour</a>
                                <button class="btn btn-secondary ml-2" type="submit">Valider</button>
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>
@endsection 
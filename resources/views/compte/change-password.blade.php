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
                                <h3 class="text-center">Changer mon mot de passe</h3><br>
                                <div class="frm_submit_wrap">
                                    <div class="form-row">

                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-success">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Mot de passe</label>
                                            <input type="text" name="current_password" placeholder="*****************************" class="form-control">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Nouveau mot de passe</label>
                                            <input type="text" name="nex_pawsword" placeholder="*****************************" class="form-control">
                                        </div>
                                    

                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Confirmer le mot de passe</label>
                                            <input type="text" name="confirm_password" placeholder="*****************************" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                                <a href="/" class="btn btn-danger ml-2 text-white" type="submit">Annuler & Retour</a>
                                <button class="btn btn-secondary ml-2" type="submit">Enregistrer</button>
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

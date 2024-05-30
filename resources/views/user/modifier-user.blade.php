@extends('layout')

@section('content')  
<div class="col-lg-9 col-md-8 mt-3">
    <div class="dashboard-body">
        <!-- row -->
        <div class="dashboard-wraper">
            <div class="row">
                <!-- Submit Form -->
                <div class="col-lg-12 col-md-12">
                    <form action="{{route('users.update')}}" method="post">
                             @csrf
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">	
                                @if (session('error'))
                                    <div class="col-md-4  p-2 text-center">
                                        <div class="alert text-white alert-danger" style="background: #e2062c;" role="alert"> {{session('error')}} 
                                        </div>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="col-md-4  p-2 text-center">
                                        <div class="alert text-white alert-success" style="background:green;"  role="alert"> {{session('success')}} 
                                        </div>
                                    </div>
                                @endif
                                <h3 class="text-center">Modifier un nouvel utilisateur</h3><br>
                                <div class="frm_submit_wrap">
                                    <div class="form-row">
                                         <input type="hidden" name="id" value="{{$user->id}}">
                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Nom et prénoms</label>
                                            <input type="text" name="username" value="{{$user->username}}" class="form-control">
                                        </div>

                                        <div class="form-group col-lg-4 col-md-12">
                                            <label>Numero téléphone </label>
                                            <input type="number" name="telephone" value="{{$user->telephone}}" class="form-control">
                                        </div>
                                    

                                        <div class="form-group col-md-4">
                                            <label>Role</label>
                                            <select id="role" name="role" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="admin" {{$user->role == "admin" ? 'selected' : ''}} >Admin</option>
                                                <option value="manager" {{$user->role == "manager" ? 'selected' : ''}}>Manager</option>
                                                <option value="user" {{$user->role == "user" ? 'selected' : ''}}>Utilisateur</option>
                                                <option value="deposant" {{$user->role == "deposant" ? 'selected' : ''}}>Déposant</option>
                                                <option value="caissiere" {{$user->role == "caissiere" ? 'selected' : ''}}>Caissière</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Marchand</label>
                                            <select id="marchand_id" name="marchand_id" class="form-control" required>
                                            <option value="">choisir</option>
                                                @foreach ($marchands as $marchand)
                                                <option value="{{$marchand->id}}" {{$user->marchand_id == $marchand->id ? 'selected' : ''}}>{{$marchand->nom}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{$user->email}}" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12">
                                <a href="{{route('users.index')}}" class="btn btn-danger ml-2 text-white" type="submit">Annuler & Retour</a>
                                <button class="btn btn-secondary ml-2" type="submit">Modifier</button>
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
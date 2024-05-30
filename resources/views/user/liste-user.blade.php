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
                              <input type="text" class="form-control" placeholder="Rechercher un utilisateur">
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
                            <a href="{{route('users.create')}}" class="prt_submit_link"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-block d-md-block"> Nouvel utilisateur</span></a>
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
                                  <th scope="col">#</th>
                                  <th scope="col">Nom & prénoms</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Contact</th>
                                  <th scope="col">Clé d'accès</th>
                                  <th scope="col">Role</th>
                                  <th scope="col"></th>
                                </tr> 
                            </thead>
                            <tbody>
                                <!-- tr block -->
                                @php
                                   $i=1
                                @endphp 

                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->telephone}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->code}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        <div class="_leads_action">
                                            <a href="{{route('users.delete', ['id' => $user->id])}}" onclick="return confirm('Etes-vous sure de vouloir supprimer ce enregistrement ?')"><i class="fas fa-trash"></i></a>
                                            <a href="{{route('users.edit', ['id' => $user->id])}}"><i class="fas fa-edit"></i></a>
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
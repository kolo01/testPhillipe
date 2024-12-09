@extends('layout')

@section('content')
    <div class="col-lg-9 col-md-8 mt-3">
        <div class="dashboard-body">
            <!-- row -->
            <div class="dashboard-wraper">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">
                                <h3 class="text-center">Mon compte</h3><br>
                                <div class="frm_submit_wrap">
                                    <div class="form-row">

                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label>Nom & Prénoms </label>
                                            <input type="text" class="form-control" value="{{ $user->username }}"
                                                readonly>
                                        </div>


                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label>Contact</label>
                                            <input type="number" name="contact" class="form-control"
                                                value="{{ $user->telephone }}" readonly>
                                        </div>

                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                        </div>

                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="{{ $user->role }}" readonly>
                                        </div>

                                    </div>
                                </div>
                            </div>

                          <form action="/updateImage" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                              <div class="frm_submit_wrap">
                                  <div class="form-row">

                                      <div class="form-group col-lg-6 col-sm-12">
                                        <label>Photo De Profils </label>
                                        <input type="file" class="form-control" accept="images/*"  name="photoProfils">
                                      </div>


                                  </div>
                              </div>
                              <div class="form-group col-lg-12 col-md-12">
                                  <button type="submit"  class="btn btn-danger ml-2 text-white"><i class="ti-import mr-2"></i>Changer la photo</button>
                              </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="dashboard-wraper mt-5 mb-10">
                <div class="row">
                    <!-- Submit Form -->
                    <div class="col-lg-12 col-md-12">
                        <div class="submit-page">
                            <!-- Information -->
                            <div class="frm_submit_block">
                                <h3 class="text-center">Information Bancaire</h3><br>
                                <form action="/modifier-rib" method="post">
                                  @csrf
                                  @method('POST')
                                    <div class="frm_submit_wrap">
                                        <div class="form-row">

                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>RIB </label>
                                                <input type="text" id="rib" name="rib" class="form-control" value="{{ $marchand->rib }}">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button type="submit"  class="btn btn-danger ml-2 text-white"> <i class="ti-edit   mr-2"></i>Modifier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

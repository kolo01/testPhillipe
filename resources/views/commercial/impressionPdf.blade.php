<!DOCTYPE html>
<html>
<head>
    <title>Bpay Recap generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.cs" >
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>Fait dans  {{$marchand->infobusiness}}</p>

    <div class="col-lg-9 col-md-8 mt-3">
      <div class="dashboard-body">
          <!-- row -->
          <div class="dashboard-wraper">
              <div class="row">
                  <!-- Submit Form -->
                  <div class="col-lg-12 col-md-12">
                      <form method="post" action="{{route('marchand.mise-ajour')}}" enctype="multipart/form-data">
                              @csrf
                    <div class="submit-page">
                      <!-- Information -->
                      <div class="frm_submit_block">
                          <h3 class="text-center "style="color: #fff;background:#144273; text-align:center">Details de {{ $marchand->nom }} </h3><br>
                          <div class="frm_submit_wrap">
                              <div class="form-row">
                                  <input type="hidden" id="___val"  name="id" value="{{$marchand->id}}">
                                  <div class="form-group col-lg-12 col-md-12" >
                                    <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                      <label style="font-weight:bold">Raison sociale</label>
                                      <P  name="nom" >{{ $marchand->nom }}</P>
                                    </div>
                                  </div>

                                  <div class="form-group col-lg-12 col-md-12">
                                    <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label style="font-weight:bold">Numero du registre de commerce ou autre</label>
                                      <P type="text">{{ $marchand->registrecommerce }}</P>
                                    </div>
                                  </div>



                                  <div class="form-group col-lg-12 col-md-12">
                                     <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                      <label style="font-weight:bold">Contact</label>
                                      <p type="number" >{{ $marchand->contact }}</p>
                                  </div>



                                  <div class="form-group col-lg-12 col-md-12">
                                     <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                      <label style="font-weight:bold">Prévision de transaction</label>
                                      <p type="number" readonly name="prevision_transac" >{{ $marchand->prevision_transac }}</p>
                                  </div>

                                  <div class="form-group col-lg-12 col-md-12">
                                     <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                      <label style="font-weight:bold">Tranche par transaction</label>
                                      <p type="text"  >{{ $marchand->tranche_transac }}</p>
                                  </div>
                                  <div class="form-group col-lg-12 col-md-12">
                                     <div class="form-group col-lg-6 col-md-12 mx-auto" style="display: flex; justify-content: space-between ">
                                    <label style="font-weight:bold">Tranche par retrait</label>
                                    <p type="text" >{{ $marchand->tranche_retrait }}</p>
                                </div>

                              </div>
                          </div>
                      </div>

                  </div>

                      </form>
                  </div>
              </div>
          </div>
          <!-- row -->
      </div>
  </div>


</body>
</html>

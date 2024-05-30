<!DOCTYPE html>

<html lang="fr" class="js no-framed skrollr skrollr-desktop">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bpay - Portail de connexion</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- For Bing -->
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/css/payment.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

    <style>
        .intl-tel-input {
            display: block !important;
        }

        .fv-control-feedback {
            padding: 8px;
        }
    </style>

</head>
<body>
<section class="bg-white pt-7 pb-0" style="margin-bottom: 0em;">
    <div class="container-fluid">  
        <div class="viewport">
            <div class="container">
                <div class="row justify-content-center align-items-center vh-200">
                    <div class="col-md-10 col-lg-10 bg-white p-2 text-center mt-6">
        
                        <div class="tab-content" id="demo-1">
                            <div class="tab-pane active show" id="marchand" role="tabpanel" aria-labelledby="marchand">
                                <div class="col-12 mb-3" style="justify-content: center;width:100%;">
                                    <p href="#" class="mb-3"><img style="justify-content:center;" src="assets/img/image/logo/logo.png"  width="5%" class="logo" alt="babimo_logo" /> <span style="color: #000000;font-weight: bold;">Bpay</span> </p>
                                    <p style="font-style: italic;">Portail de connexion   </p>
                                </div>
                                <form name="login-form" id="login-form" class="form-signin fv-form fv-form-bootstrap4" method="post" novalidate="novalidate">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <input name="email" type="email" class="form-control" id="email" placeholder="Adresse email" data-fv-field="email" required><br>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-md-12">
                                            <button  id="connexion"   class="btn btn-primary">Connexion</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
        
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>     
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{asset('assets/js/login.js')}}"></script>


</body>
</html>
<!DOCTYPE html>

<html lang="fr" class="js no-framed skrollr skrollr-desktop">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bpay - compte administrateur</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- For Bing -->
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="assets/css/payment.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <style>
        .intl-tel-input {
            display: block !important;
        }

        .fv-control-feedback {
            padding: 8px;
        }

        @media screen and (max-width: 768px) {
            .connected {
                width: 100%;
            }
        }

        @media screen and (min-width: 768px) {
            .connected {
                width: 26.5%;
            }
        }

    </style>

</head>
<body>
<section class="bg-white pt-7 pb-0" style="margin-bottom: 0em;">
    <div class="container-fluid">  
        <div class="viewport">
            <div class="container">
                <div class="row justify-content-center align-items-center vh-200">
                       @if (session('error'))
                            <div class="col-md-6  p-2 text-center">
                                <div class="alert text-white alert-danger" style="background: #e2062c;" role="alert">{{session('error')}} 
                                </div>
                            </div>
                        @endif
                    <div class="col-md-10 col-lg-10 bg-white p-2 text-center mt-6">
                        <div class="tab-content" id="demo-1">
                            <div class="tab-pane active show" id="marchand" role="tabpanel" aria-labelledby="marchand">
                                <div class="col-12 mb-3" style="justify-content: center;width:100%;">
                                    <p href="#" class="mb-3"><img style="justify-content:center;" src="assets/img/image/logo/logo.png"  width="5%" class="logo" alt="babimo_logo" /> <span style="color: #000000;font-weight: bold;">Bpay</span> </p>
                                    <p style="font-style: italic;">Portail de connexion   </p>
                                </div>
                                <form name="login-form" id="login-form" class="form-signin fv-form fv-form-bootstrap4" action="{{ route('otp.generate') }}" method="post" novalidate="novalidate">
                                                                                                       @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group">
                                                <select name="page_option" class="form-control" id="page_option">
                                                    <option value="">Aucun</option>
                                                    <option value="email_page"></option>
                                                    <option value="phone_page"></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input name="email" type="tel" class="form-control" id="email" placeholder="Adresse email" data-fv-field="email" required><br>
                                                <p id="valid-msg" class="hide d-none fs-12" style="color:green;font-style: italic;">Valide</p>
                                                <span id="error-msg" class="hide text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <button type="submit" id="connexion" class="btn btn-primary connected" >Connexion</button>
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
<script src="{{asset('assets/js/telephone.js')}}"></script>



</body>
</html>
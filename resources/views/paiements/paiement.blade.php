<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js no-framed skrollr skrollr-desktop">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>babimo - Ouvrer un compte marchand</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- For Bing -->
    <meta name="theme-color" content="#ffffff">
    <base href="/">
    <link rel="stylesheet" href="{{asset('assets/css/payment.css')}}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
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
@if(isset($paiement->paymentMethod))
    <section class="bg-white pt-7 pb-0" style="margin-bottom: 0em;">
        <div class="container-fluid">
            <div class="viewport">
                <div class="container">
                    <div class="row justify-content-center align-items-center vh-200">
                        <div class="col-md-9 col-lg-9 bg-white p-2 text-center mt-6">
                            <div class="tab-content" id="demo-1">
                                <div class="tab-pane active show" id="marchand" role="tabpanel"
                                     aria-labelledby="marchand">
                                    <div class="card">
                                        <form action="" method="post">
                                            <div class="card-header"
                                                 style="justify-content: space-between;width:100%;display:flex;">
                                                <a href="#">
                                                    <img style="margin-left:-90%;"
                                                         src="assets/img/image/logo/logo.png"
                                                         style="margin-left: -10%;" width="5%" class="logo"
                                                         alt="babimo_logo"/>
                                                    <span style="color: #000000;font-weight: bold;">Bpay</span>
                                                </a>
                                                <p style="font-style: italic;">Paiement chez
                                                    <span class="text-black">Babimo</span>
                                                    <br>
                                                    <span
                                                        style="font-weight: bold;font-size:16px;color:#000000;">{{ $paiement->amount }}</span>
                                                    xof </p>
                                            </div>
                                            <div class="card-body">
                                                <form name="login-form" id="login-form"
                                                      class="form-signin fv-form fv-form-bootstrap4"
                                                      method="post"
                                                      novalidate="novalidate">
                                                    <button type="submit" class="fv-hidden-submit"
                                                            style="display: none; width: 0px; height: 0px;"></button>
                                                    <div class="row">
                                                        <input type="hidden" value="1" id="operateur"
                                                               name="operateur">
                                                        <div class="col-lg-12 col-sm-12 mb-2">
                                                            <div>
                                                            </div>
                                                            @if($paiement->paymentMethod == "OM_CI")
                                                                <img src="assets/img/image/operateurs/orange.jpg"
                                                                     width="10%;"
                                                                     style="border: 2px solid #e5e5e5;border-radius:0.25rem;"
                                                                     alt=""
                                                                     srcset="">
                                                            @endif
                                                            @if($paiement->paymentMethod == "WAVE_CI")
                                                                <img src="assets/img/image/operateurs/wave.jpg"
                                                                     width="10%;"
                                                                     style="border: 2px solid #e5e5e5;border-radius:0.25rem;"
                                                                     alt=""
                                                                     srcset="">
                                                            @endif
                                                            @if($paiement->paymentMethod == "MTN_CI")
                                                                <img src="assets/img/image/operateurs/mtn.jpg"
                                                                     width="10%;"
                                                                     style="border: 2px solid #e5e5e5;border-radius:0.25rem;"
                                                                     alt=""
                                                                     srcset="">
                                                            @endif
                                                            @if($paiement->paymentMethod == "MOOV_CI")
                                                                <img src="assets/img/image/operateurs/moov.jpg"
                                                                     width="10%;"
                                                                     style="border: 2px solid #e5e5e5;border-radius:0.25rem;"
                                                                     alt=""
                                                                     srcset="">
                                                            @endif
                                                        </div>
                                                        {{--<div class="col-lg-3 col-sm-12 mr-2">
                                                            <div class="form-group">
                                                                <input type="text" value="Orange"  class="form-control" id="design-operateur" readonly style="text-align:center;background:#fff;">
                                                            </div>
                                                        </div>--}}
                                                        <div class="col-lg-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input name="telephone" type="tel"
                                                                       class="form-control" id="phone"
                                                                       placeholder="Numéro mobile money"
                                                                       data-fv-field="telephone"
                                                                       required><br>
                                                                <p id="valid-msg"
                                                                   class="hide d-none fs-12"
                                                                   style="color:green;font-style: italic;">Valide</p>
                                                                <span id="error-msg"
                                                                      class="hide text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" id="payer"
                                                            class="btn btn-primary btn-block"
                                                            style="font-style: italic;">Payer
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="card-footer">
                                                <p class="text-center"
                                                   style="font-size: 11px;font-style:italic;">Paiement sécurisé par
                                                    <span style="color:#000000;font-weight:bold;">Babimo</span></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@if(!isset($paiement->paymentMethod))
    <section class="bg-white pt-7 pb-0" style="margin-bottom: 0em;">
        <div class="container-fluid">
            <div class="viewport">
                <div class="container">
                    <div class="row justify-content-center align-items-center vh-200">
                        <div class="col-md-9 col-lg-9 bg-white p-2 text-center mt-6">
                            <div class="tab-content" id="demo-1">
                                <div class="tab-pane active show" id="marchand" role="tabpanel"
                                     aria-labelledby="marchand">
                                    <div class="card">
                                        <form action="" method="post">
                                            <div class="card-header"
                                                 style="justify-content: space-between;width:100%;display:flex;">
                                                <a href="#">
                                                    <img style="margin-left:-90%;"
                                                         src="assets/img/image/logo/logo.png"
                                                         style="margin-left: -10%;" width="5%" class="logo"
                                                         alt="babimo_logo"/>
                                                    <span style="color: #000000;font-weight: bold;">Bpay</span>
                                                </a>
                                                <p style="font-style: italic;">Paiement chez
                                                    <span
                                                        style="font-weight: bold;font-size:16px;color:#000000;">Babimo</span>
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                Impossible de faire cette operation
                                            </div>
                                            <div class="card-footer">
                                                <p class="text-center" style="font-size: 11px;font-style:italic;">Paiement sécurisé par
                                                <span style="color:#000000;font-weight:bold;">Babimo</span></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/phone.js')}}"></script>
</body>
</html>

<!DOCTYPE html>

<html lang="fr" class="js no-framed skrollr skrollr-desktop">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bpay -Verification OTP</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- For Bing -->
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('assets/css/payment.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <style>
        .intl-tel-input {
            display: block !important;
        }

        .fv-control-feedback {
            padding: 8px;
        }

        /* Default styling for the input field */
        .input-field {
            width: 5%;
            margin: 2px;
        }

        /* Media query for small screens */
        @media screen and (max-width: 600px) {
            .input-field {
            width: 15%; /* Set width to 100% for small screens */
            margin: 10px; /* Adjust margin as needed */
            }
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
                    <div class="col-md-4  p-2 text-center">
                        <div class="alert text-white alert-danger" style="background: #e2062c;" role="alert"> {{session('error')}} 
                        </div>
                    </div>
                    @endif
                    <div class="col-md-10 col-lg-10 bg-white p-2 text-center mt-6">
                        <div class="tab-content" id="demo-1">
                            <div class="tab-pane active show" id="marchand" role="tabpanel" aria-labelledby="marchand">
                                <div class="col-12 mb-3" style="justify-content: center;width:100%;">
                                    <p href="#" class="mb-3"><img style="justify-content:center;" src="{{asset('assets/img/image/logo/logo.png')}}"  width="5%" class="logo" alt="babimo_logo" /> <span style="color: #000000;font-weight: bold;">Bpay</span> </p>
                                    <p style="font-style: italic;">Portail de connexion   </p>
                                </div>
                                <form name="otp-form" action="{{ route('otp.getlogin') }}" id="otp-form" class="form-signin fv-form fv-form-bootstrap4" method="post" novalidate="novalidate">
                                            @csrf
                                    <input type="hidden" name="code" value="{{$code}}" />
                                    <div class="row justify-content-center">
                                        <div class="input-field">
                                            <div class="form-group">
                                                <input name="otp[]" type="text" maxlength="1" pattern="[0-9]" class="form-control text-center" id="otp1" placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="input-field">
                                            <div class="form-group">
                                                <input name="otp[]" type="text" maxlength="1" pattern="[0-9]" class="form-control text-center" id="otp2" placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="input-field">
                                            <div class="form-group">
                                                <input name="otp[]" type="text" maxlength="1" pattern="[0-9]" class="form-control text-center" id="otp3" placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="input-field">
                                            <div class="form-group">
                                                <input name="otp[]" type="text" maxlength="1" pattern="[0-9]" class="form-control text-center" id="otp4" placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <button type="submit" id="valide-otp"  class="btn btn-primary connected" >Valider</button>
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
<script>
    const inputs = document.querySelectorAll('input[type="text"]');

inputs.forEach(input => {
  input.addEventListener('input', restrictInput);

});

function restrictInput(event) {
  const input = event.target;
  const inputValue = input.value.trim();
  const isValidInput = /^[0-9]$/.test(inputValue);

  if (!isValidInput) {
    input.value = '';
  }
  focusNextInput(event)
}

function focusNextInput(event) {
      const input = event.target;
      const maxLength = parseInt(input.getAttribute('maxlength'), 10);
      const inputValue = input.value.trim();

      if (inputValue.length === maxLength) {
        const nextIndex = Array.from(inputs).indexOf(input) + 1;
        if (nextIndex < inputs.length) {
          const nextInput = inputs[nextIndex];
          nextInput.focus();
        }
      }
    }
</script>


</body>
</html>
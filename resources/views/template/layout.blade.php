<!DOCTYPE html>
<html lang="en">
	
<head>
		<meta charset="utf-8" />
		<meta name="author" content="Sokowave" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bpay</title>
		 
        <!-- Custom CSS -->
        <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
	
    <body class="yellow-skin">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== --> 
       <div class="preloader"></div>
            <div id="main-wrapper">
                <div class="clearfix"></div>
                <section class="gray pt-0 pb-5">
                    <div class="container-fluid">               
                        <div class="row">
                            @yield('content')
                        </div>
                    </div> 
                </section>           
            </div>
  
        
		<!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.js') }}"></script>
        <script src="{{ asset('assets/js/slider-bg.js') }}"></script>
        <script src="{{ asset('assets/js/lightbox.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
        <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready( function () {
                // $('#search').on('keyup', function() {
                //     if (event.keyCode === 13) { // Vérifie si la touche "Enter" est pressée
                //         var searchValue = $(this).val();
                //         $('input[type="search"]').val(searchValue).trigger($.Event('keypress', { keyCode: 13 }));
                //     }
                // });

                $('#myTable').DataTable({
                    pagingType: "simple_numbers",
                    lengthMenu:[5,10,15,20,25],
                    pageLength: 3,
                    language: {
                    processing:     "Traitement en cours...",
                    search:         "Rechercher&nbsp;:",
                    lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                    info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "Pr&eacute;c&eacute;dent",
                        next:       "Suivant",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
                });

            } );
        </script>

		<!-- Morris.js charts -->
        <script src="{{ asset('assets/js/raphael.min.js') }}"></script>
        <script src="{{ asset('assets/js/morris.min.js') }}"></script>

        <!-- Custom Morrisjs JavaScript -->
        <script src="{{ asset('assets/js/morris.js') }}"></script>

			
		<!-- ============================================================== -->
		<!-- This page plugins -->
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- ============================================================== -->
        <script src="{{asset('assets/js/env.js')}}"></script>
   
        <script src="{{asset('assets/js/lkll.js')}}"></script>
      
	</body>
    
</html>
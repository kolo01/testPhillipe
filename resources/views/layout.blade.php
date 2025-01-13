<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="Babimo Pay" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bpay</title>

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="icon" href="{{ asset('assets/image/logo/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.plot.ly/plotly-2.20.0.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<style>
    .nav_text {
        font-size: 16px !important;
    }
</style>

<body class="yellow-skin">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader"></div>
    <div id="main-wrapper">
        <div style='background-color:red;'>
            <div class="header header-light">
                <div class="container">
                    <nav id="navigation" class="navigation navigation-landscape">
                        <div class="nav-header">
                            <a class="nav-brand" href="#"><img src="{{ asset('assets/img/image/logo/logo.png') }}"
                                    width="15%" class="logo" alt="babimo_logo" /> <span
                                    style="color: #000000;font-weight: bold;">Bpay</span> </a>
                            <p id="nameUser" class="text-bold text-center"
                                style="color: #000000;font-size:16px;margin-left:15em;">
                                @if (\DB::table('marchands')->where('id', auth()->user()->marchand_id)->value('service_status') == '1')
                                    {{ 'VOUS ÊTES EN MODE TEST' }}
                                @endif
                            </p>
                        </div>
                        <div class="nav-menus-wrapper">

                            <ul class="nav-menu nav-menu-social align-to-right dhsbrd">
                                <li>
                                    <div class="btn-group account-drop d-flex">
                                        <button type="button" class="btn btn-order-by-filt mr-3" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ asset('assets/img/image/logo/person.jpg') }}"
                                                class="avater-img" alt="">
                                        </button>
                                        <p id='nameUser' class="text-bold" style="color: #000000;font-size:16px;">
                                            {{ Auth::user()->username }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="clearfix"></div>
            <section class="gray pt-0 pb-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 ajust-nav">
                            <div class="property_dashboard_navbar">
                                <div class="m-4"></div>
                                <div class="dash_user_menues">
                                    <ul class="nav_text">
                                        {{-- @dd(auth()->user()->role) --}}
                                        @if (auth()->user()->role == 'commercial')
                                            <li
                                                class="{{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('dashboard.index') }}"><i
                                                        class="fa fa-home fa-lg" style="color:#203dcf;"></i>Tableau de
                                                    bord</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'commercial.dashboard' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('commercial.dashboard') }}"><i
                                                        class="fa fa-home fa-lg" style="color: #2471A3;"></i>Mes
                                                    marchands</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'commercial.statistic' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('commercial.statistic') }}"><i
                                                        class="fa fa-cubes fa-lg"
                                                        style="color:#bf0559;"></i>Statistiques</a>
                                            </li>
                                        @else
                                            <li
                                                class="{{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('dashboard.index') }}"><i
                                                        class="fa fa-home fa-lg" style="color:#203dcf;"></i>Tableau de
                                                    bord</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'liste.transactions' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('liste.transactions') }}"><i
                                                        class="fa fa-coins fa-lg" style="color:#F7DC6F;"></i>Suivi des
                                                    transactions</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'liste.statistique' || Route::currentRouteName() == 'liste.statistiqueSearch' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('liste.statistique') }}"><i
                                                        class="fa fa-cubes fa-lg"
                                                        style="color:#bf0559;"></i>Statistiques</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'view.transaction.manager' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('view.transaction.manager') }}"><i
                                                        class="ti-wallet fa-lg" style="color:#F86F03;"></i>Gérer mes
                                                    fonds</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'marchand.ribindex' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('marchand.ribindex') }}"><i
                                                        class="ti-money fa-lg" style="color:blue;"></i>Retrait avec
                                                    RIB</a>
                                            </li>
                                            <li
                                                class="{{ Route::currentRouteName() == 'view.depot' ? 'active' : '' }}">
                                                <a class="nav_text" href="{{ route('view.depot') }}"><i
                                                        class="fa fa-file fa-lg" style="color:green;"></i>Dépôt</a>
                                            </li>
                                            @if (auth()->user()->role == 'superAdmin')
                                                <!-- <li class="{{ Route::currentRouteName() == 'view.transaction.manager' ? 'active' : '' }}"><a class="nav_text" href="{{ route('view.transaction.manager') }}"><i class="ti-wallet fa-lg"   style="color:#F86F03;"></i>Gestion des fonds</a></li> -->
                                                <li
                                                    class="{{ Route::currentRouteName() == 'liste.operateur' ? 'active' : '' }}">
                                                    <a class="nav_text" href="{{ route('liste.operateur') }}"><i
                                                            class="fa fa-cog fa-lg" style="color: #2471A3;"></i>Gérer
                                                        les
                                                        opérateurs</a>
                                                </li>
                                                <li
                                                    class="{{ Route::currentRouteName() == 'marchand.index' || Route::currentRouteName() == 'marchand.ajouter' || Route::currentRouteName() == 'marchand.modifier' ? 'active' : '' }}">
                                                    <a class="nav_text" href="{{ route('marchand.index') }}"><i
                                                            class="fa fa-landmark fa-lg"
                                                            style="color: #99A3A4;"></i>Gérer les
                                                        marchands</a>
                                                </li>
                                                <li
                                                    class="{{ Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.edit' ? 'active' : '' }}">
                                                    <a class="nav_text" href="{{ route('users.index') }}"><i
                                                            class="fa fa-users fa-lg" style="color: purple;"></i>Gérer
                                                        les
                                                        utilisateurs</a>
                                                </li>
                                                <li
                                                    class="{{ Route::currentRouteName() == 'profil.info' ? 'active' : '' }}">
                                                    <a class="nav_text" href="{{ route('profil.info') }}"><i
                                                            class="fa fa-user fa-lg" style="color: #9972e6;"></i>Mon
                                                        compte</a>
                                                </li>
                                                <li class=""><a class="nav_text" target="_blank"
                                                        href="https://documenter.getpostman.com/view/12042091/2s93sW7FD9"><i
                                                            class="fa fa-file-code fa-lg"
                                                            style="color: #9972e6;"></i>Documentation</a></li>
                                            @else
                                                <li
                                                    class="{{ Route::currentRouteName() == 'profil.info' ? 'active' : '' }}">
                                                    <a class="nav_text" href="{{ route('profil.info') }}"><i
                                                            class="fa fa-user fa-lg" style="color: #9972e6;"></i>Mon
                                                        compte</a>
                                                </li>
                                                <li class=""><a class="nav_text" target="_blank"
                                                        href="https://documenter.getpostman.com/view/12042091/2s93sW7FD9"><i
                                                            class="fa fa-file-code fa-lg"
                                                            style="color: #9972e6;"></i>Documentation</a></li>
                                                <li style="height: 20rem;"></li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                                <div class="dash_user_footer">
                                    <ul>
                                        <li><a href="#" data-toggle="modal" data-target="#logout"><i
                                                    class="fa fa-power-off"></i></a></li>
                                        <li><a href="{{ url('/mon-compte') }}"><i
                                                    class="fa fa-user-tie fa-lg"></i></a>
                                        </li>
                                        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </section>
            <!-- Logout Modal -->
            <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logoutmodal"
                aria-hidden="true">
                <div class="modal-dialog modal-md login-pop-form" role="document">
                    <div class="modal-content overli" id="logoutmodal">
                        <div class="modal-body p-0">
                            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i
                                    class="ti-close"></i></span>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel"
                                            aria-labelledby="pills-login-tab">
                                            <div class="login-form">
                                                <div class="form-group text-center">
                                                    <p class="mb-2">Êtes vous sûrs de vouloir vous <span
                                                            class="text-black text-bold">déconnecter</span> ?</p>
                                                    <button data-dismiss="modal"
                                                        class="btn btn-sm btn-danger mr-4 fs-3">Non</button>
                                                    <button onclick="document.getElementById('logout-form').submit();"
                                                        class="btn btn-sm btn-secondary ml-4 fs-3">Oui</button>
                                                </div>
                                                <form id="logout-form" action="{{ route('logout.user') }}"
                                                    method="post" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Locked Modal -->
            <div class="modal fade" id="lock-marchand" tabindex="-1" role="dialog"
                aria-labelledby="lockMarchand-modal" aria-hidden="true">
                <div class="modal-dialog modal-md login-pop-form" role="document">
                    <div class="modal-content overli" id="lockMarchand-modal">
                        <div class="modal-body p-0">
                            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i
                                    class="ti-close"></i></span>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel"
                                            aria-labelledby="pills-login-tab">
                                            <div class="login-form">
                                                <div class="form-group text-center">
                                                    <p class="mb-2">Êtes-vous sûrs de vouloir déconnecter <span
                                                            class="text-black text-bold">ce marchand</span> ?</p>
                                                    <button data-dismiss="modal"
                                                        class="btn btn-sm btn-danger mr-4 fs-3">Non</button>
                                                    <button id="logoutBtn"
                                                        class="btn btn-sm btn-secondary ml-4 fs-3">Oui</button>
                                                </div>
                                                <form id="lockMarchand-form">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <!-- detail transaction Modal -->
            <div class="modal fade" id="detailTransac-marchand" tabindex="-1" role="dialog"
                aria-labelledby="detailTransac-modal" aria-hidden="true">
                <div class="modal-dialog modal-xl login-pop-form" role="document">
                    <div class="modal-content overli" id="detailTransac-modal">
                        <div class="modal-body p-0">
                            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i
                                    class="ti-close"></i></span>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel"
                                            aria-labelledby="pills-login-tab">
                                            <div class="login-form">
                                                <h4 class="text-center">Détail de la transaction</h4>
                                                <div class="clearfix mb-4"></div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>Montant reçu</p>
                                                    <p>4.000F</p>
                                                </div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>Frais</p>
                                                    <p>60F</p>
                                                </div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>Statut</p>
                                                    <p>Effectué</p>
                                                </div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>Date et heure</p>
                                                    <p>09/05/2023 09:47</p>
                                                </div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>Nouveau solde</p>
                                                    <p>4.060F</p>
                                                </div>
                                                <div
                                                    style="display: flex; justify-content: space-between; width: 100%;">
                                                    <p>ID de la transaction</p>
                                                    <p>T64UE3LSHOY</p>
                                                </div>
                                                <div class="clearfix mb-2"></div>
                                                <a type="button" data-dismiss="modal"
                                                    class="btn btn-sm btn-danger text-white float-right">Fermer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End detail transaction Modal -->
        </div>
        <footer id="footer" class="dark-footer text-white d-flex-column">
            <hr class="mb-0">
            <div class="py-3 text-center">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script> Bpay | Developped by Babimo
            </div>
        </footer>

        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

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
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#search').on('keyup', function() {
            //     if (event.keyCode === 13) { // Vérifie si la touche "Enter" est pressée
            //         var searchValue = $(this).val();
            //         $('input[type="search"]').val(searchValue).trigger($.Event('keypress', { keyCode: 13 }));
            //     }
            // });

            $('#myTable').DataTable({
                pagingType: "simple_numbers",
                processing: true,
                serverSide: true,
                lengthMenu: [5, 10, 15, 20, 25],
                pageLength: 3,
                language: {
                    processing: "Traitement en cours...",
                    search: "Rechercher&nbsp;:",
                    lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                    info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix: "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable: "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first: "Premier",
                        previous: "Pr&eacute;c&eacute;dent",
                        next: "Suivant",
                        last: "Dernier"
                    },
                    aria: {
                        sortAscending: ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });    


        });
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
    @yield('script')
    <!-- ============================================================== -->
    <script src="{{ asset('assets/js/env.js') }}"></script>

        </script>
         @yield('page-scripts')
      
	</body>
    
</html>
    <script src="{{ asset('assets/js/lkll.js') }}"></script>
    <script>
        TESTER = document.getElementById('tester');
        var data = [{
            x: ['2023-10-04 22:23:00', '2023-11-05 22:23:00', '2023-12-01 22:23:00'],
            y: [0, 0, 0],
            type: 'scatter'
        }];

        Plotly.newPlot(TESTER, data);
    </script>

</body>

</html>

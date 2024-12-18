<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="theme-color" content="#0061f2">

    <title>Asamblea</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.0.0/signature_pad.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">

        <div class="page-header-icon"></div>
        <a class="navbar-brand d-none d-sm-block">Asamblea PH
        </a>

        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"
            href="#"><i data-feather="menu"></i></button>

            <ul class="navbar-nav align-items-center ml-auto">
                <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                        href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img class="img-fluid"
                         src="{{ asset('img/logo.png') }}" alt="Logo" width="60" height="60">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                        aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                      
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"> {{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->role : 'Copropietario' }}</div><br>
                                <div class="dropdown-user-details-email"> {{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->name : 'Copropietario' }}</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item">
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-link d-flex align-items-center">
                                    <i class="fa-solid fa-right-from-bracket" style="color: darkslategray"></i>
                                    <span class="ml-2"  style="color: darkslategray">Salir</span>
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
                
               
            </ul>
           
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                       
                      
                        <div class="sidenav-menu-heading">Administrar</div>
                        <a class="nav-link" href="{{ route('residentes.index') }}">
                            <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                            Generar Informe
                        </a>

                       
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                <span>@yield('name')</span>
                            </h1>
                            <div class="page-header-subtitle"></div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    @yield('content')
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; Your Website {{ now()->year }}</div>
                        <div class="col-md-6 text-sm-right small">
                            <a href="#!">Desarrollo:</a>
                            &middot;
                            <a href="https://xn--oscarcaas-r6a.co/">Oscar Cañas - Juan Pablo Cañas</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    @section('content')
        <!-- Tu contenido aquí -->
    @endsection


    <!-- Librerías externas (CDNs) -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <!-- Archivos locales -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script>
    <!-- Bootstrap CSS -->
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>

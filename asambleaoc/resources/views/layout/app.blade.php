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

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-link">
                    <span> Salir</span>
                </a>
            </form>

        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Rol:
                            {{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->role : 'Copropietario' }}<br>Usuario:
                            {{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->name : 'Copropietario' }}
                        </div>

                        <div class="sidenav-menu-heading">Administrar</div>
                        <a class="nav-link" href="{{ route('residentes.index') }}">
                            <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                            Listado
                        </a>
                        <a class="nav-link" href="{{ route('buscar.apto.form') }}">
                            <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                            Buscar Copropietario
                        </a>
                        <a class="nav-link" href="{{ route('residentes.create') }}">
                            <div class="nav-link-icon"><i data-feather="tool"></i></i></div>
                            Cargar Excel
                        </a>
                        <a class="nav-link" href="{{ route('residentes.estadisticas') }}">
                            <div class="nav-link-icon"><i data-feather="filter"></i></div>
                            Quorum
                        </a>
                        <a class="nav-link" href="{{ route('datos.index') }}">
                            <div class="nav-link-icon"><i data-feather="tool"></i></div>
                            Configuración
                        </a>
                    </div>
                </div>
                <div
                    style="display: flex; justify-content: center; align-items: center; height: 150px; border: 1px solid #ddd; background-color: #f9f9f9;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                        width="70" height="70" alt="Logo">
                </div>

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

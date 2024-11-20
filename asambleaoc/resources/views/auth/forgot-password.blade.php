<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Página de recuperación de contraseña" />
    <meta name="author" content="Oscar Cañas - Juan Pablo Cañas" />
    <title>Recuperar Contraseña - Tu Sitio</title>
    <!-- Referencia a los estilos CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    
    <!-- Fuente de FontAwesome para íconos -->
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center text-sm">
                                    <h3 class="font-weight-light  my-4">{{ __('Recuperar Contraseña') }}</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Mensaje de instrucción -->
                                    <div class="mb-4 text-xs text-muted">
                                        {{ __('¿Olvidaste tu contraseña? No te preocupes, solo indícanos tu correo electrónico y te enviaremos un enlace para restablecerla. Podrás elegir una nueva contraseña.') }}
                                    </div>

                                    <!-- Mensaje de estado -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <!-- Formulario para enviar enlace de reinicio -->
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <!-- Campo de dirección de correo electrónico -->
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">{{ __('Correo electrónico') }}</label>
                                            <input class="form-control py-4" id="email" type="email" name="email" :value="old('email')" required autofocus />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Botón para enviar el formulario -->
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                {{ __('Enviar Link') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small">
                                        <a href="{{ route('login') }}">{{ __('Regresar al login') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div id="layoutAuthentication_footer">
            <footer class="footer mt-auto footer-dark">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Copyright -->
                        <div class="col-md-6 small">
                            &copy; {{ now()->year }} <span>Tu Sitio Web</span>
                        </div>
                        <!-- Información de desarrollo -->
                        <div class="col-md-6 text-md-right small">
                            <span>Desarrollo:</span>
                            &middot;
                            <a href="https://xn--oscarcaas-r6a.co/" target="_blank" rel="noopener noreferrer">
                                Oscar Cañas - Juan Pablo Cañas
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Incluir scripts JS de Bootstrap y otros -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

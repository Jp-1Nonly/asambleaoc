<x-guest-layout>
    <head>
        <!-- Referencia correcta a los estilos -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="font-weight-light my-4">{{ __('Bienvenido') }}</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Mensajes de Estado de Sesión -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <!-- Formulario de Login -->
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <!-- Email Address -->
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">{{ __('Correo') }}</label>
                                            <input class="form-control py-4" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group mt-4">
                                            <label class="small mb-1" for="password">{{ __('Contraseña') }}</label>
                                            <input class="form-control py-4" id="password" type="password" name="password" required autocomplete="current-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="form-group mt-4">
                                            <div class="custom-control custom-checkbox">
                                                <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                                <label for="remember_me" class="custom-control-label">{{ __('Recordarme') }}</label>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            @if (Route::has('password.request'))
                                                <a class="small" href="{{ route('password.request') }}">{{ __('Olvidó su contraseña?') }}</a>
                                            @endif
                                            <button type="submit" class="btn btn-primary btn-sm">{{ __('Ingresar') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small">
                                        <a href="{{ route('register') }}">{{ __('Need an account? Sign up!') }}</a>
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
                        <div class="col-md-6 small">Copyright &copy; Your Website {{ now()->year }}</div>
                        <div class="col-md-6 text-md-right small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</x-guest-layout>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Página de registro de usuario" />
    <meta name="author" content="Oscar Cañas - Juan Pablo Cañas" />
    <meta name="theme-color" content="#0061f2">
    <title>Registro - ##</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
        crossorigin="anonymous"></script>
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
                                    <h3 class="font-weight-light  my-4">{{ __('Registro de cuenta nueva') }}</h3>
                                </div>
                                <div class="card-body">
                                    <x-auth-session-status class="mb-4" :status="session('status')" />
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label class="small mb-1" for="name">{{ __('Nombre') }}</label>
                                            <input class="form-control py-4" id="name" type="text"
                                                name="name" :value="old('name')" required autofocus
                                                autocomplete="name" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <!-- Select para Rol -->
                                        <div class="form-group mb-3">
                                            <label for="role" class="form-label">Rol</label>
                                            <select id="role" name="role" class="form-control" required>
                                                <option value="Administrador">Administrador</option>
                                                <option value="Auxiliar">Auxiliar</option>
                                                <option value="Superusuario">Superusuario</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="small mb-1" for="email">{{ __('Correo electrónico') }}</label>
                                            <input class="form-control py-4" id="email" type="email"
                                                name="email" :value="old('email')" required
                                                autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="small mb-1" for="password">{{ __('Contraseña') }}</label>
                                            <input class="form-control py-4" id="password" type="password"
                                                name="password" required autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="form-group mt-4">
                                            <label class="small mb-1"
                                                for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                                            <input class="form-control py-4" id="password_confirmation" type="password"
                                                name="password_confirmation" required autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>

                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="{{ route('login') }}">{{ __('Ya tiene cuenta?') }}</a>
                                            <button type="submit" class="btn btn-primary btn-sm ms-4">
                                                {{ __('Registrar') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>

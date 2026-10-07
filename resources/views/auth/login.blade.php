@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

{{-- Cambiamos @section por @push para ganarle en prioridad a los estilos por defecto --}}
@push('css')
    <style>
        /* Cambia el fondo gris por una espectacular tienda de vinilos difuminada */
        html, body, body.login-page {
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.85)),
            url('https://cdn.pixabay.com/photo/2024/11/07/10/27/record-shop-9180482_1280.jpg') !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            height: 100vh !important;
        }

        /* Estiliza el botón de inicio de sesión para que sea amarillo */
        .btn-primary {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: #000 !important;
            font-weight: bold;
        }

        /* Opcional: Cambia el color del botón cuando pasas el mouse por encima (hover) */
        .btn-primary:hover {
            background-color: #e0a800 !important;
            border-color: #d39e00 !important;
            color: #000 !important;
        }
    </style>
@endpush

{{-- Tu sección auth_body se queda exactamente igual --}}
@section('auth_body')
    <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Campo de Correo Electronico --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Campo de Contrasena --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Boton de Ingresar --}}
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="fas fa-sign-in-alt"></span> Ingresar
                </button>
            </div>
        </div>
        <p class="mb-1 mt-3">
            <a href="{{ route('password.request') }}" class="text-warning">Olvidé mi contraseña</a>
        </p>
        <p class="mb-0">
            <a href="{{ route('register') }}" class="text-warning text-center">Registrar una nueva cuenta</a>
        </p>
    </form>
@endsection

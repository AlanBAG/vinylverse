@extends('adminlte::page')

@section('title', 'Inicio - VinylVerse')

@section('content_header')
    <h1 style="text-align: center; color: #ffc107; font-family: 'Inter', sans-serif; font-size: 2.0rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">
        Bienvenidos a VinylVerse
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- INICIO DEL CARRUSEL DE BOOTSTRAP --}}
                <div id="carruselVinilos" class="carousel slide shadow rounded" data-ride="carousel" data-interval="4000">

                    {{-- Indicadores inferiores (Puntitos) --}}
                    <ol class="carousel-indicators">
                        <li data-target="#carruselVinilos" data-slide-to="0" class="active"></li>
                        <li data-target="#carruselVinilos" data-slide-to="1"></li>
                        <li data-target="#carruselVinilos" data-slide-to="2"></li>
                    </ol>

                    {{-- Contenedor de los Slides --}}
                    <div class="carousel-inner text-center bg-dark rounded">

                        {{-- 1er Slide (Activo por defecto) --}}
                        <div class="carousel-item active">
                            <img src="https://cdn.pixabay.com/photo/2024/11/07/10/27/record-shop-9180482_1280.jpg" class="d-block w-100 img-fluid style-carousel-img" alt="Colección de Vinilos Clásicos" style="max-height: 450px; object-fit: cover; opacity: 0.8;">
                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); padding: 15px; border-radius: 10px;">
                                <h3 class="text-warning">¡Joyas del Rock Clásico!</h3>
                                <p>Explora nuestra exclusiva colección de vinilos remasterizados de los 70s y 80s.</p>
                            </div>
                        </div>

                        {{-- 2do Slide --}}
                        <div class="carousel-item">
                            <img src="https://f52df18294f32b8a71d712281a8658b7.cdn.bubble.io/cdn-cgi/image/w=768,h=256,f=auto,dpr=2.5,fit=contain/d72/f1661174970402x502658146927675650/yamac_0589_2560.jpg" class="d-block w-100 img-fluid style-carousel-img" alt="Nuevos Lanzamientos" style="max-height: 450px; object-fit: cover; opacity: 0.8;">
                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); padding: 15px; border-radius: 10px;">
                                <h3 class="text-warning">Nuevos Lanzamientos Semanales</h3>
                                <p>Mantente al día con lo último del Jazz, Pop e Indie directamente a tu tornamesa.</p>
                            </div>
                        </div>

                        {{-- 3er Slide --}}
                        <div class="carousel-item">
                            <img src="https://i.redd.it/ffs6em08eiw21.jpg" class="d-block w-100 img-fluid style-carousel-img" alt="Ofertas Especiales" style="max-height: 450px; object-fit: cover; opacity: 0.8;">
                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); padding: 15px; border-radius: 10px;">
                                <h3 class="text-warning">Ediciones Limitadas - 20% OFF</h3>
                                <p>Aprovecha descuentos únicos en discos de color y picture discs esta semana.</p>
                            </div>
                        </div>

                    </div>

                    {{-- Flechas de Control (Anterior y Siguiente) --}}
                    <a class="carousel-control-prev" href="#carruselVinilos" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carruselVinilos" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>

                </div>
                {{-- FIN DEL CARRUSEL --}}

            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Intercepta cualquier clic en enlaces que apunten a /logout o que tengan el ID del sidebar
            $(document).on('click', 'a[href*="logout"], #btn-logout-sidebar', function(e) {
                e.preventDefault(); // Detiene el método GET por defecto

                // Crea un formulario POST dinámico hacia la ruta de logout de Laravel
                var form = $('<form>', {
                    'action': '{{ route("logout") }}',
                    'method': 'POST'
                }).append($('<input>', {
                    'name': '_token',
                    'value': '{{ csrf_token() }}', // Token CSRF obligatorio
                    'type': 'hidden'
                }));

                // Adjunta el formulario al body y lo envía inmediatamente
                $('body').append(form);
                form.submit();
            });
        });
    </script>
@stop

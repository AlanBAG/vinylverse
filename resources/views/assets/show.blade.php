@extends('adminlte::page')

@section('title', 'Ver Recurso')

@section('content_header')
    <h1>Recurso: {{ $asset->nombre_original }}</h1>
@stop

@section('content')
    <div class="container-fluid text-center">
        <div class="card">
            <div class="card-body">

                @if(str_contains($asset->tipo_mime, 'image'))
                    <h3>Visualización de Imagen</h3>
                    {{-- Apunta al método getImage --}}
                    <img src="{{ route('assets.getImage', $asset->id) }}" class="img-fluid rounded border" style="max-height: 500px;">

                @elseif(str_contains($asset->tipo_mime, 'video'))
                    <h3>Reproductor de Video</h3>
                    {{-- Apunta al método getVideo --}}
                    <video width="80%" height="auto" controls class="border rounded">
                        <source src="{{ route('assets.getVideo', $asset->id) }}" type="{{ $asset->tipo_mime }}">
                        Tu navegador no soporta la reproducción de este video.
                    </video>
                @endif

            </div>
            <div class="card-footer text-left">
                <a href="{{ route('assets.create') }}" class="btn btn-secondary">Subir otro archivo</a>
            </div>
        </div>
    </div>
@stop

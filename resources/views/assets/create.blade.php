@extends('adminlte::page')

@section('title', 'Subir Recurso')

@section('content_header')
    <h1>Disco Duro Virtual - Subir Archivo</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Selecciona una Imagen o Video</h3>
            </div>

            {{-- IMPORTANTE: enctype="multipart/form-data" para permitir subir archivos --}}
            <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="archivo">Archivo (Imágenes o Videos MP4):</label>
                        <input type="file" name="archivo" class="form-control-file" id="archivo" required>
                        <small class="text-muted">Formatos admitidos: jpg, jpeg, png, mp4, avi</small>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Subir al Almacenamiento</button>
                </div>
            </form>
        </div>
    </div>
@stop

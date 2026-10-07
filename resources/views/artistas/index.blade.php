@extends('adminlte::page')

@section('title', 'Artistas')

@section('content_header')
    <h1>Listado de Artistas</h1>
@stop

@section('content')
    <div class="container-fluid">

        <a href="{{ route('artistas.create') }}" class="btn btn-success mb-3">
            Nuevo Artista
        </a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- Tabla con ID y con el encabezado "Estado" corregido --}}
                    <table id="tablaArtistas" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>País</th>
                            <th>Género</th>
                            <th>Estado</th> {{-- Añadido para que coincida con tus td --}}
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- Se llena dinámicamente con AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL GLOBAL DE ELIMINACIÓN --}}
    <div class="modal fade" id="modalEliminarArtista" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Confirmar eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>¿Deseas eliminar al artista <strong id="nombreArtistaEliminar"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="formEliminarArtista" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar DataTables para Artistas
            var table = $('#tablaArtistas').DataTable({
                "ajax": "{{ route('artistas.cargarDT') }}",
                "columns": [
                    { "data": "id" },
                    { "data": "nombre" },
                    { "data": "pais" },
                    { "data": "genero" },
                    {
                        "data": "deleted_at",
                        "render": function(data) {
                            return data ? '<span class="badge bg-danger">Eliminado</span>' : '<span class="badge bg-success">Activo</span>';
                        }
                    },
                    {
                        "data": null,
                        "orderable": false,
                        "render": function(data, type, row) {
                            // Construcción de rutas dinámicas
                            let urlEdit = `{{ route('artistas.edit', ':id') }}`.replace(':id', row.id);
                            let urlRestore = `{{ route('artistas.restore', ':id') }}`.replace(':id', row.id);

                            if (!row.deleted_at) {
                                return `
                                <a href="${urlEdit}" class="btn btn-warning btn-sm">Editar</a>
                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-artista" data-id="${row.id}" data-nombre="${row.nombre}">Eliminar</button>
                            `;
                            } else {
                                return `
                                <form action="${urlRestore}" method="POST" style="display:inline">
                                    @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm">Restaurar</button>
                            </form>
`;
                            }
                        }
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            // Evento para activar el modal dinámicamente
            $('#tablaArtistas').on('click', '.btn-eliminar-artista', function() {
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let urlDestroy = `{{ route('artistas.destroy', ':id') }}`.replace(':id', id);

                $('#nombreArtistaEliminar').text(nombre);
                $('#formEliminarArtista').attr('action', urlDestroy);
                $('#modalEliminarArtista').modal('show');
            });
        });
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Vinilos')

@section('content_header')
    <h1>Listado de Vinilos</h1>
@stop

@section('content')
    <div class="container-fluid">

        <a href="{{ route('vinilos.create') }}" class="btn btn-primary mb-3">
            Nuevo Vinilo
        </a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- AGREGAMOS EL ID EN LA TABLA Y QUITAMOS EL FOREACH --}}
                    <table id="tablaVinilos" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Género</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
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

    {{-- MODAL GLOBAL DE ELIMINACIÓN (Uno solo para toda la tabla) --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Confirmar eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>¿Deseas eliminar el vinilo <strong id="nombreViniloEliminar"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="formEliminar" method="POST">
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
            // Inicialización de DataTables apuntando a tu método cargarDT
            var table = $('#tablaVinilos').DataTable({
                "ajax": "{{ route('vinilos.cargarDT') }}",
                "columns": [
                    { "data": "id" }, // Si usas id_vinilo cámbialo aquí
                    {
                        "data": "imagen",
                        "render": function(data) {
                            return data ? `<img src="{{ asset('storage/vinilos') }}/${data}" width="60">` : 'Sin imagen';
                        }
                    },
                    { "data": "titulo" },
                    { "data": "genero" },
                    {
                        "data": "precio",
                        "render": function(data) { return '$' + parseFloat(data).toFixed(2); }
                    },
                    { "data": "stock" },
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
                            // Construimos las rutas de edición dinámicamente
                            let urlEdit = `{{ route('vinilos.edit', ':id') }}`.replace(':id', row.id);
                            let urlRestore = `{{ route('vinilos.restore', ':id') }}`.replace(':id', row.id);

                            if (!row.deleted_at) {
                                return `
                                <a href="${urlEdit}" class="btn btn-warning btn-sm">Editar</a>
                                <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="${row.id}" data-titulo="${row.titulo}">Eliminar</button>
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

            // Evento para abrir el modal de eliminación dinámico
            $('#tablaVinilos').on('click', '.btn-eliminar', function() {
                let id = $(this).data('id');
                let titulo = $(this).data('titulo');
                let urlDestroy = `{{ route('vinilos.destroy', ':id') }}`.replace(':id', id);

                $('#nombreViniloEliminar').text(titulo);
                $('#formEliminar').attr('action', urlDestroy);
                $('#modalEliminar').modal('show');
            });
        });
    </script>
@stop

@extends('adminlte::page')
@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <h2>Lista de Categorías</h2>
            <hr>
            <br>
            <p class="text-end">
                <a href="{{ route('categoria.create') }}" class="btn btn-success">Registrar Categoría</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Regresar</a>
            </p>
            <table id="categorias-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="categoriaConfirmDelete" tabindex="-1" aria-labelledby="categoriaConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoriaConfirmDeleteLabel">Eliminar categoría</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirma la eliminación de la categoría <strong id="categoria-nombre"></strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteCategoriaForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script>
        const categoriasData = @json($categorias);
        const editUrlTemplate = "{{ route('categoria.edit', ':id') }}";
        const deleteUrlTemplate = "{{ route('categoria.delete', ['categoria' => ':id']) }}";

        const encodeAttr = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        $(document).ready(function () {
            const tableData = Array.isArray(categoriasData) ? categoriasData.map((categoria) => {
                const editUrl = editUrlTemplate.replace(':id', categoria.id);
                const deleteUrl = deleteUrlTemplate.replace(':id', categoria.id);
                const nombreAttr = encodeAttr(categoria.nombre_categoria);
                const deleteButton = `<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#categoriaConfirmDelete" data-categoria-nombre="${nombreAttr}" data-categoria-delete="${deleteUrl}">Eliminar</button>`;
                const editButton = `<a href="${editUrl}" class="btn btn-sm btn-primary me-1">Editar</a>`;
                return {
                    acciones: editButton + deleteButton,
                    id: categoria.id,
                    nombre: categoria.nombre_categoria ?? '',
                    descripcion: categoria.descripcion ?? '',
                    estado: categoria.estado_categoria ?? ''
                };
            }) : [];

            $('#categorias-table').DataTable({
                data: tableData,
                columns: [
                    { data: 'acciones', orderable: false, searchable: false },
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'descripcion' },
                    { data: 'estado' }
                ],
                pageLength: 100,
                order: [[1, 'asc']],
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "No hay datos disponibles en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando 0 a 0 de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Ultimo",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                },
                responsive: true,
                dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
                buttons: [
                    'copy',
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LETTER'
                    }
                ]
            });

            const deleteModal = document.getElementById('categoriaConfirmDelete');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const trigger = event.relatedTarget;
                    if (!trigger) return;
                    const categoriaNombre = trigger.getAttribute('data-categoria-nombre') || '';
                    const deleteUrl = trigger.getAttribute('data-categoria-delete');
                    const nombreContainer = document.getElementById('categoria-nombre');
                    if (nombreContainer) {
                        nombreContainer.textContent = categoriaNombre;
                    }
                    const deleteForm = document.getElementById('deleteCategoriaForm');
                    if (deleteForm && deleteUrl) {
                        deleteForm.action = deleteUrl;
                    }
                });
            }
        });
    </script>
@endsection

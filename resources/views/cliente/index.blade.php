@extends('adminlte::page')
@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="row">
            <h2>Lista de Clientes</h2>
            <hr>
            <br>
            <p class="text-end">
                <a href="{{ route('plantillapdf.clientepdf') }}" class="btn btn-outline-secondary">Descargar informe</a>
                <a href="{{ route('cliente.create') }}" class="btn btn-success">Registrar Cliente</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Regresar</a>
            </p>
            <table id="clientes-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>C.P.</th>
                        <th>Telefono</th>
                        <th>Correo electronico</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="clienteConfirmDelete" tabindex="-1" aria-labelledby="clienteConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="clienteConfirmDeleteLabel">Eliminar cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirma la eliminacion del cliente <strong id="cliente-nombre"></strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteClienteForm" method="POST">
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
        const clientesData = @json($clientes);
        const editUrlTemplate = "{{ route('cliente.edit', ':id') }}";
        const deleteUrlTemplate = "{{ route('cliente.delete', ['cliente' => ':id']) }}";

        const encodeAttr = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        $(document).ready(function() {
            const tableData = Array.isArray(clientesData) ? clientesData.map((cliente) => {
                const editUrl = editUrlTemplate.replace(':id', cliente.id);
                const nombreAttr = encodeAttr(cliente.nombre);
                const deleteButton = `<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#clienteConfirmDelete" data-cliente-id="${cliente.id}" data-cliente-nombre="${nombreAttr}">Eliminar</button>`;
                const editButton = `<a href="${editUrl}" class="btn btn-sm btn-primary me-1">Editar</a>`;
                return {
                    acciones: editButton + deleteButton,
                    id: cliente.id,
                    nombre: cliente.nombre ?? '',
                    domicilio: cliente.domicilio ?? '',
                    ciudad: cliente.ciudad ?? '',
                    cp: cliente.cp ?? '',
                    telefono: cliente.telefono ?? '',
                    email: cliente.email ?? ''
                };
            }) : [];

            $('#clientes-table').DataTable({
                data: tableData,
                columns: [
                    { data: 'acciones', orderable: false, searchable: false },
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'domicilio' },
                    { data: 'ciudad' },
                    { data: 'cp' },
                    { data: 'telefono' },
                    { data: 'email' }
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

            const deleteModal = document.getElementById('clienteConfirmDelete');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const trigger = event.relatedTarget;
                    if (!trigger) {
                        return;
                    }
                    const clienteId = trigger.getAttribute('data-cliente-id');
                    const clienteNombre = trigger.getAttribute('data-cliente-nombre') || '';
                    const nombreContainer = document.getElementById('cliente-nombre');
                    if (nombreContainer) {
                        nombreContainer.textContent = clienteNombre;
                    }
                    const deleteForm = document.getElementById('deleteClienteForm');
                    if (deleteForm && clienteId) {
                        deleteForm.action = deleteUrlTemplate.replace(':id', clienteId);
                    }
                });
            }
        });
    </script>
@endsection

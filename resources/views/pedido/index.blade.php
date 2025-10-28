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
            <h2>Lista de Pedidos</h2>
            <hr>
            <br>
            <p class="text-end">
                <a href="{{ route('pedido.create') }}" class="btn btn-success">Registrar pedido</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Regresar</a>
            </p>
            <table id="pedidos-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Método de pago</th>
                        <th>Total</th>
                        <th>Cliente</th>
                        <th># Detalles</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="pedidoConfirmDelete" tabindex="-1" aria-labelledby="pedidoConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pedidoConfirmDeleteLabel">Eliminar pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirma la eliminación del pedido de <strong id="pedido-label"></strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deletePedidoForm" method="POST">
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
        const pedidosData = @json($pedidos);
        const editUrlTemplate = "{{ route('pedido.edit', ':id') }}";
        const deleteUrlTemplate = "{{ route('pedido.delete', ['pedido' => ':id']) }}";

        $(document).ready(function () {
            const tableData = Array.isArray(pedidosData) ? pedidosData.map((pedido) => {
                const deleteUrl = deleteUrlTemplate.replace(':id', pedido.id);
                return {
                    acciones: pedido.acciones,
                    id: pedido.id,
                    fecha: pedido.fecha ?? '',
                    estado: pedido.estado ?? '',
                    metodo_pago: pedido.metodo_pago ?? '',
                    total: pedido.total ?? '0.00',
                    cliente: pedido.cliente ?? 'Invitado',
                    detalles: pedido.detalles ?? 0,
                    deleteUrl,
                    label: pedido.cliente ?? 'Invitado'
                };
            }) : [];

            const table = $('#pedidos-table').DataTable({
                data: tableData,
                columns: [
                    {
                        data: 'acciones',
                        orderable: false,
                        searchable: false,
                    },
                    { data: 'id' },
                    { data: 'fecha' },
                    { data: 'estado' },
                    { data: 'metodo_pago' },
                    { data: 'total' },
                    { data: 'cliente' },
                    { data: 'detalles' },
                ],
                pageLength: 100,
                order: [[1, 'desc']],
                language: {
                    sProcessing: 'Procesando...',
                    sLengthMenu: 'Mostrar _MENU_ registros',
                    sZeroRecords: 'No se encontraron resultados',
                    sEmptyTable: 'No hay datos disponibles en esta tabla',
                    sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                    sInfoEmpty: 'Mostrando 0 a 0 de 0 registros',
                    sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
                    sSearch: 'Buscar:',
                    sLoadingRecords: 'Cargando...',
                    oPaginate: {
                        sFirst: 'Primero',
                        sLast: 'Último',
                        sNext: 'Siguiente',
                        sPrevious: 'Anterior',
                    },
                    oAria: {
                        sSortAscending: ': Activar para ordenar la columna de manera ascendente',
                        sSortDescending: ': Activar para ordenar la columna de manera descendente',
                    },
                },
                responsive: true,
                dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
                buttons: [
                    'copy',
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                    },
                ],
            });

            $('#pedidos-table').on('click', '[data-bs-target="#pedidoConfirmDelete"]', function () {
                const rowData = table.row($(this).closest('tr')).data();
                const modal = document.getElementById('pedidoConfirmDelete');
                const labelContainer = document.getElementById('pedido-label');
                const deleteForm = document.getElementById('deletePedidoForm');
                if (!modal || !rowData) {
                    return;
                }
                if (labelContainer) {
                    labelContainer.textContent = rowData.label ?? '';
                }
                if (deleteForm) {
                    deleteForm.action = rowData.deleteUrl;
                }
            });
        });
    </script>
@endsection

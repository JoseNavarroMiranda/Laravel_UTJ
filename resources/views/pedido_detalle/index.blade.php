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
            <h2>Lista de detalles de pedido</h2>
            <hr>
            <br>
            <p class="text-end">
                <a href="{{ route('pedido_detalle.create') }}" class="btn btn-success">Registrar detalle</a>
                <a href="{{ route('pedido.index') }}" class="btn btn-primary">Ver pedidos</a>
            </p>
            <table id="pedido-detalles-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="pedidoDetalleConfirmDelete" tabindex="-1" aria-labelledby="pedidoDetalleConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pedidoDetalleConfirmDeleteLabel">Eliminar detalle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirma la eliminación del detalle de <strong id="pedido-detalle-label"></strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deletePedidoDetalleForm" method="POST">
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
        const pedidoDetallesData = @json($detalles);
        const editUrlTemplate = "{{ route('pedido_detalle.edit', ':id') }}";
        const deleteUrlTemplate = "{{ route('pedido_detalle.delete', ['pedido_detalle' => ':id']) }}";

        $(document).ready(function () {
            const tableData = Array.isArray(pedidoDetallesData) ? pedidoDetallesData.map((detalle) => {
                const editUrl = editUrlTemplate.replace(':id', detalle.id);
                const deleteUrl = deleteUrlTemplate.replace(':id', detalle.id);
                return {
                    acciones: detalle.acciones,
                    id: detalle.id,
                    pedido: detalle.pedido ?? '',
                    cliente: detalle.cliente ?? 'Invitado',
                    producto: detalle.producto ?? '',
                    cantidad: detalle.cantidad ?? 0,
                    precio_unitario: detalle.precio_unitario ?? '0.00',
                    subtotal: detalle.subtotal ?? '0.00',
                    deleteUrl,
                    label: `Pedido #${detalle.pedido}`
                };
            }) : [];

            const table = $('#pedido-detalles-table').DataTable({
                data: tableData,
                columns: [
                    {
                        data: 'acciones',
                        orderable: false,
                        searchable: false,
                    },
                    { data: 'id' },
                    { data: 'pedido' },
                    { data: 'cliente' },
                    { data: 'producto' },
                    { data: 'cantidad' },
                    { data: 'precio_unitario' },
                    { data: 'subtotal' },
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

            $('#pedido-detalles-table').on('click', '[data-bs-target="#pedidoDetalleConfirmDelete"]', function () {
                const rowData = table.row($(this).closest('tr')).data();
                const modal = document.getElementById('pedidoDetalleConfirmDelete');
                const labelContainer = document.getElementById('pedido-detalle-label');
                const deleteForm = document.getElementById('deletePedidoDetalleForm');
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

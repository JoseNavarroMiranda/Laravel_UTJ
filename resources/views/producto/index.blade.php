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
            <h2>Lista de Productos</h2>
            <hr>
            <br>
            <p class="text-end">
                <a href="{{ route('producto.create') }}" class="btn btn-success">Registrar Producto</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Regresar</a>
            </p>
            <table id="productos-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                        <th>Imágenes</th>
                        <th>Video</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="productoConfirmDelete" tabindex="-1" aria-labelledby="productoConfirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="productoConfirmDeleteLabel">Eliminar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confirma la eliminación del producto <strong id="producto-nombre"></strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteProductoForm" method="POST">
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
        const productosData = @json($productos);
        const editUrlTemplate = "{{ route('producto.edit', ':id') }}";
        const deleteUrlTemplate = "{{ route('producto.delete', ['producto' => ':id']) }}";
        const imageBaseUrl = "{{ asset('images') }}";
        const videoBaseUrl = "{{ asset('videos') }}";

        const encodeAttr = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        const buildImagenHtml = (producto) => {
            const rutas = [];
            if (producto.imagen_producto) {
                rutas.push(producto.imagen_producto);
            }
            if (Array.isArray(producto.imagenes)) {
                producto.imagenes.forEach((ruta) => {
                    if (ruta && !rutas.includes(ruta)) {
                        rutas.push(ruta);
                    }
                });
            }

            if (!rutas.length) {
                return '<span class="text-muted">Sin imagen</span>';
            }

            const thumbs = rutas.slice(0, 3).map((ruta) => {
                const encoded = encodeURIComponent(ruta);
                return `<img src="${imageBaseUrl}/${encoded}" alt="Imagen de producto" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">`;
            }).join('');

            if (rutas.length > 3) {
                const restantes = rutas.length - 3;
                return `${thumbs}<span class="badge bg-secondary ms-2">+${restantes}</span>`;
            }

            return thumbs;
        };

        const buildVideoHtml = (producto) => {
            if (!producto.video_producto) {
                return '<span class="text-muted">Sin video</span>';
            }
            const encoded = encodeURIComponent(producto.video_producto);
            return `<a href="${videoBaseUrl}/${encoded}" target="_blank" rel="noopener">Ver video</a>`;
        };

        $(document).ready(function () {
            const tableData = Array.isArray(productosData) ? productosData.map((producto) => {
                const editUrl = editUrlTemplate.replace(':id', producto.id);
                const deleteUrl = deleteUrlTemplate.replace(':id', producto.id);
                const nombreAttr = encodeAttr(producto.nombre_producto ?? '');
                const deleteButton = `<button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#productoConfirmDelete" data-producto-id="${producto.id}" data-producto-nombre="${nombreAttr}" data-producto-delete="${deleteUrl}">Eliminar</button>`;
                const editButton = `<a href="${editUrl}" class="btn btn-sm btn-primary me-1">Editar</a>`;
                const precioNumero = Number(producto.precio ?? 0);
                const precioTexto = Number.isFinite(precioNumero)
                    ? precioNumero.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
                    : encodeAttr(producto.precio);
                const descripcion = encodeAttr(producto.descripcion ?? '');
                const estado = encodeAttr(producto.estado_producto ?? '');
                const categoria = encodeAttr(producto.categoria_id ?? '');
                const proveedor = encodeAttr(producto.proveedor_id ?? '');
                const stock = encodeAttr(producto.stock ?? '');

                return {
                    acciones: editButton + deleteButton,
                    id: producto.id,
                    nombre: nombreAttr,
                    descripcion,
                    precio: precioTexto,
                    stock,
                    estado,
                    categoria,
                    proveedor,
                    imagen: buildImagenHtml(producto),
                    video: buildVideoHtml(producto),
                };
            }) : [];

            $('#productos-table').DataTable({
                data: tableData,
                columns: [
                    { data: 'acciones', orderable: false, searchable: false },
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'descripcion' },
                    { data: 'precio' },
                    { data: 'stock' },
                    { data: 'estado' },
                    { data: 'categoria' },
                    { data: 'proveedor' },
                    { data: 'imagen', orderable: false, searchable: false },
                    { data: 'video', orderable: false, searchable: false }
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
                        sLast: "Último",
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

            const deleteModal = document.getElementById('productoConfirmDelete');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const trigger = event.relatedTarget;
                    if (!trigger) {
                        return;
                    }
                    const productoNombre = trigger.getAttribute('data-producto-nombre') || '';
                    const deleteUrl = trigger.getAttribute('data-producto-delete');
                    const nombreContainer = document.getElementById('producto-nombre');
                    if (nombreContainer) {
                        nombreContainer.textContent = productoNombre;
                    }
                    const deleteForm = document.getElementById('deleteProductoForm');
                    if (deleteForm && deleteUrl) {
                        deleteForm.action = deleteUrl;
                    }
                });
            }
        });
    </script>
@endsection

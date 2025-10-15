@extends('vistasbase.body')

@section('title', 'Producto: ' . $producto->nombre_producto)
@section('page_header', 'Detalle del producto')

@section('content')
    @includeIf('vistasbase.navbar')

    <section class="producto-detalle-wrapper">
        <div class="producto-detalle-card card shadow-sm">
            <div class="row g-0 flex-md-row">
                <div class="col-lg-5">
                    <div class="producto-detalle-media h-100">
                        @if (!empty($producto->imagen_producto))
                            <img src="{{ asset('images/' . $producto->imagen_producto) }}" class="producto-detalle-imagen"
                                alt="{{ $producto->nombre_producto }}">
                        @else
                            <div class="producto-detalle-placeholder d-flex align-items-center justify-content-center">
                                <span>Sin imagen disponible</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-body h-100 d-flex flex-column">
                        <h1 class="producto-detalle-titulo">{{ $producto->nombre_producto }}</h1>
                        <p class="producto-detalle-descripcion">{{ $producto->descripcion }}</p>

                        <dl class="producto-detalle-meta">
                            <div class="meta-item">
                                <dt>Precio</dt>
                                <dd>${{ number_format($producto->precio, 2) }}</dd>
                            </div>
                            <div class="meta-item">
                                <dt>Stock</dt>
                                <dd>{{ $producto->stock }}</dd>
                            </div>
                            <div class="meta-item">
                                <dt>Estado</dt>
                                <dd>
                                    <span
                                        class="badge {{ ($producto->estado_producto ?? '') === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($producto->estado_producto ?? 'desconocido') }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                        @php
                            $video = $producto->video_producto;
                            $extension = strtolower(pathinfo($video ?? '', PATHINFO_EXTENSION));
                            $esImagen = in_array($extension, ['gif', 'jpg', 'jpeg', 'png', 'webp']);
                        @endphp

                        @if (!empty($video))
                            <div class="producto-detalle-video mb-4">
                                @if ($esImagen)
                                    <img src="{{ asset('videos/' . $video) }}" class="w-100" alt="Vista del producto">
                                @else
                                    <video src="{{ asset('videos/' . $video) }}" controls class="w-100"></video>
                                @endif
                            </div>
                        @endif

                        <div class="producto-detalle-actions mt-auto">
                            <a href="{{ route('dashboardecommerce.index') }}" class="btn btn-link">Volver al dashboard</a>
                            <button type="button" class="btn btn-primary">Anadir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .producto-detalle-wrapper {
            padding: 24px;
        }

        .producto-detalle-card {
            overflow: hidden;
        }

        .producto-detalle-media {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 320px;
        }

        .producto-detalle-imagen {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 4 / 3;
        }

        .producto-detalle-placeholder {
            width: 100%;
            height: 100%;
            min-height: 320px;
            background: rgba(0, 0, 0, 0.05);
            color: var(--muted);
        }

        .producto-detalle-titulo {
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 600;
        }

        .producto-detalle-descripcion {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 24px;
        }

        .producto-detalle-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .producto-detalle-meta dt {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .producto-detalle-meta dd {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .producto-detalle-video video {
            width: 100%;
            border-radius: 8px;
        }

        .producto-detalle-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 768px) {
            .producto-detalle-wrapper {
                padding: 16px;
            }

            .producto-detalle-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

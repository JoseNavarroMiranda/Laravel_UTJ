@extends('vistasbase.body')

@section('title', 'Panel de cliente')
@section('page_header', 'Panel de cliente')

@section('content')
    @includeIf('vistasbase.navbar')

    <section class="dashboard-shell">
        <div class="dashboard-card card">
            <div class="card-body">
                <h2 class="dashboard-title">Productos</h2>
                <div class="productos-grid">
                    @forelse(($productos ?? []) as $producto)
                        <article class="producto-card card shadow-sm h-100">
                            <div class="producto-imagen-wrapper">
                                @if(!empty($producto->imagen_producto))
                                    <img src="{{ asset('images/'.$producto->imagen_producto) }}"
                                         class="producto-imagen rounded-top"
                                         alt="{{ $producto->nombre_producto }}">
                                @else
                                    <div class="producto-placeholder d-flex align-items-center justify-content-center">
                                        <span>Sin imagen</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="producto-titulo">{{ $producto->nombre_producto }}</h3>
                                <p class="producto-descripcion mb-2">{{ $producto->descripcion }}</p>
                                <div class="producto-meta mb-3">
                                    <span class="producto-precio">Precio: ${{ number_format($producto->precio, 2) }}</span>
                                    <span>Stock: {{ $producto->stock }}</span>
                                    <span class="badge {{ ($producto->estado_producto ?? '') === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($producto->estado_producto ?? 'desconocido') }}
                                    </span>
                                </div>
                                <div class="producto-actions mt-auto">
                                    <a href="{{ route('producto.show', $producto->id) }}" class="btn btn-primary btn-sm">Abrir producto</a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Añadir</button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="dashboard-copy mb-0">Aun no hay productos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .vb-navbar {
            margin: -24px -24px 24px;
            width: calc(100% + 48px);
        }

        .dashboard-shell {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .dashboard-title {
            margin: 0 0 12px;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .dashboard-copy {
            margin: 0 0 12px;
            color: var(--muted);
            font-size: 15px;
        }

        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }

        .producto-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .producto-imagen-wrapper {
            background: #f8f9fa;
        }

        .producto-imagen {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 4 / 3;
        }

        .producto-placeholder {
            min-height: 240px;
            background: rgba(0, 0, 0, 0.05);
            font-size: 14px;
            color: var(--muted);
        }

        .producto-titulo {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 600;
        }

        .producto-descripcion {
            color: var(--muted);
            font-size: 14px;
        }

        .producto-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 14px;
            align-items: center;
        }

        .producto-precio {
            font-weight: 600;
        }

        .producto-video video {
            width: 100%;
            border-radius: 8px;
        }

        .producto-actions {
            display: flex;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .productos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

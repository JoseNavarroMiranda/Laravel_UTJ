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
                        <article class="producto-card card shadow-sm">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3">
                                    @if(!empty($producto->imagen_producto))
                                        <img src="{{ asset('images/'.$producto->imagen_producto) }}"
                                             class="img-fluid rounded-start"
                                             alt="{{ $producto->nombre_producto }}">
                                    @else
                                        <div class="producto-placeholder d-flex align-items-center justify-content-center">
                                            <span>Sin imagen</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h3 class="producto-titulo">{{ $producto->nombre_producto }}</h3>
                                        <p class="producto-descripcion mb-2">{{ $producto->descripcion }}</p>
                                        <div class="producto-meta">
                                            <span class="producto-precio">Precio: ${{ number_format($producto->precio, 2) }}</span>
                                            <span>Stock: {{ $producto->stock }}</span>
                                            <span class="badge {{ ($producto->estado_producto ?? '') === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($producto->estado_producto ?? 'desconocido') }}
                                            </span>
                                        </div>
                                        @if(!empty($producto->video_producto))
                                            <div class="producto-video mt-3">
                                                <video src="{{ asset('videos/'.$producto->video_producto) }}" controls width="280"></video>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="dashboard-copy mb-0">Aún no hay productos registrados.</p>
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
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .producto-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
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

        .producto-placeholder {
            min-height: 160px;
            background: rgba(0, 0, 0, 0.05);
            font-size: 14px;
            color: var(--muted);
        }
    </style>
@endpush

@extends('vistasbase.body')

@section('title', 'Detalle de carrito')
@section('page_header', 'Tu carrito')

@section('content')
    @includeIf('vistasbase.navbar')

    @php
        $items = $cartItems ?? session('cart.items', []);
        $items = is_array($items) ? $items : ($items instanceof \Illuminate\Support\Collection ? $items->all() : []);
        $total = 0;
    @endphp

    <section class="cart-shell">
        <div class="cart-layout">
            <div class="cart-items card">
                <div class="card-body">
                    <h2 class="cart-title">Productos añadidos</h2>

                    @if(empty($items))
                        <p class="cart-empty">Tu carrito todavía está vacío. Añade productos desde el catálogo para verlos aquí.</p>
                    @else
                        <ul class="cart-list">
                            @foreach($items as $item)
                                @php
                                    $cantidad = (int)($item['cantidad'] ?? 1);
                                    $precio = (float)($item['precio'] ?? 0);
                                    $subtotal = $cantidad * $precio;
                                    $total += $subtotal;
                                @endphp
                                <li class="cart-list-item">
                                    <div class="cart-item-media">
                                        @if(!empty($item['imagen']))
                                            <img class="cart-item-image" src="{{ asset('images/'.$item['imagen']) }}" alt="{{ $item['nombre'] ?? 'Producto' }}">
                                        @else
                                            <div class="cart-item-placeholder">Sin imagen</div>
                                        @endif
                                    </div>
                                    <div class="cart-item-info">
                                        <h3 class="cart-item-name">{{ $item['nombre'] ?? 'Producto sin nombre' }}</h3>
                                        <p class="cart-item-description">{{ $item['descripcion'] ?? 'Sin descripción disponible.' }}</p>
                                        <div class="cart-item-meta">
                                            <span class="cart-item-quantity">Cantidad: {{ $cantidad }}</span>
                                            <span class="cart-item-price">Precio unitario: ${{ number_format($precio, 2) }}</span>
                                            <span class="cart-item-subtotal">Subtotal: ${{ number_format($subtotal, 2) }}</span>
                                        </div>
                                        @if(!empty($item['id']))
                                            <div class="cart-item-actions">
                                                @if(Route::has('carrito.actualizar'))
                                                    <form method="POST" action="{{ route('carrito.actualizar', $item['id']) }}" class="cart-item-action" hidden>
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                @endif
                                                @if(Route::has('carrito.eliminar'))
                                                    <form method="POST" action="{{ route('carrito.eliminar', $item['id']) }}" class="cart-item-action" hidden>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <aside class="cart-summary card">
                <div class="card-body">
                    <h2 class="cart-summary-title">Resumen</h2>
                    <dl class="cart-summary-list">
                        <div class="cart-summary-row">
                            <dt>Productos</dt>
                            <dd>{{ empty($items) ? 0 : count($items) }}</dd>
                        </div>
                        <div class="cart-summary-row">
                            <dt>Total</dt>
                            <dd>${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>
                    <div class="cart-summary-actions">
                        <a href="{{ route('dashboardecommerce.index') }}" class="btn secondary">Seguir comprando</a>
                        <button type="button" class="btn" disabled>Proceder al pago</button>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .vb-navbar {
            margin: -24px -24px 24px;
            width: calc(100% + 48px);
        }

        .cart-shell {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .cart-layout {
            display: grid;
            gap: 24px;
            grid-template-columns: 2fr 1fr;
        }

        .cart-title {
            margin: 0 0 16px;
            font-size: 24px;
            font-weight: 600;
        }

        .cart-empty {
            margin: 0;
            color: var(--muted);
            font-size: 15px;
        }

        .cart-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cart-list-item {
            display: grid;
            gap: 18px;
            grid-template-columns: 120px 1fr;
            padding: 18px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.06);
            background: rgba(17,24,39,0.65);
        }

        .cart-item-media {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
            background: rgba(15,23,42,0.8);
        }

        .cart-item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 1;
        }

        .cart-item-placeholder {
            font-size: 13px;
            color: var(--muted);
            padding: 12px;
            text-align: center;
        }

        .cart-item-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-item-name {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .cart-item-description {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.4;
        }

        .cart-item-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 14px;
        }

        .cart-item-meta span {
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
        }

        .cart-item-actions {
            display: flex;
            gap: 8px;
        }

        .cart-summary-title {
            margin: 0 0 16px;
            font-size: 22px;
            font-weight: 600;
        }

        .cart-summary-list {
            margin: 0 0 24px;
            padding: 0;
            display: grid;
            gap: 12px;
        }

        .cart-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 16px;
        }

        .cart-summary-row dt {
            color: var(--muted);
        }

        .cart-summary-row dd {
            margin: 0;
            font-weight: 600;
        }

        .cart-summary-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        @media (max-width: 860px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .cart-list-item {
                grid-template-columns: 1fr;
            }

            .cart-item-media {
                max-height: 200px;
            }
        }
    </style>
@endpush

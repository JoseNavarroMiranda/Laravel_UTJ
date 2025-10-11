@extends('vistasbase.body')

@section('title', 'Panel de cliente')
@section('page_header', 'Panel de cliente')

@section('content')
    @includeIf('vistasbase.navbar')

    <section class="dashboard-shell">
        <div class="dashboard-card card">
            <div class="card-body">
                <h2 class="dashboard-title">Bienvenido</h2>
                <p class="dashboard-copy">
                    Aqui veras tus datos de pedidos, direcciones guardadas y novedades de LineaBlanca una vez que
                    hayamos conectado el flujo despues del inicio de sesion.
                </p>
                <p class="dashboard-copy">
                    Mientras tanto, esta pagina confirma que la plantilla ya hereda el navbar y el footer para el area
                    del cliente.
                </p>
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
    </style>
@endpush

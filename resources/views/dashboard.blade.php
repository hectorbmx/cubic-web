<x-app-layout>
  {{-- Título para la pestaña --}}
  <x-slot name="title">Dashboard</x-slot>

  <style>
    .card-head {
      display: flex;
      align-items: center;
      justify-content: space-between; /* <<< importante */
    }

    .card-number {
      font-size: 1.25rem;
      font-weight: 700;
      margin-left: auto;
    }

    .card-title {
      display: flex;
      align-items: center;
      gap: 8px;
    }
/* 
    .dashboard-wrapper {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem 3rem;
    } */

    /* Panel base */
    .panel {
      border-radius: 18px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
      margin-bottom: 22px;
      background: #ffffff;
      color: #111827;
      padding: 22px;
    }

    /* Panel azul tipo “hero” */
    .panel-hero {
      background: linear-gradient(135deg, #22314a, #274061);
      color: #ffffff;
    }

    .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .panel .title {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .panel .title .icon {
      width: 26px;
      height: 26px;
    }

    .panel-hero .subtitle {
      margin-top: 2px;
      opacity: .9;
      font-size: 0.9rem;
    }

    /* Cards resumen */
    .cards {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 16px;
      margin-top: 18px;
    }
    @media (max-width: 1024px){ .cards { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 640px){ .cards { grid-template-columns: 1fr; } }

    .card {
      border-radius: 12px;
      padding: 16px;
      border: 1px solid rgba(148, 163, 184, 0.4);
      background: #ffffff;
      color: #111827;
    }

    /* Cuando la card está dentro del hero la hacemos más “glass” */
    .panel-hero .card {
      background: rgba(255,255,255,.08);
      border-color: rgba(255,255,255,.18);
      color: #ffffff;
    }
    .panel-header-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;                   /* espacio entre los dos botones */
}

    .card-head {
      display: flex;
      align-items: center;
      gap: 10px;
      opacity: .95;
      font-size: 0.9rem;
    }

    .card-icon {
      width: 22px;
      height: 22px;
    }

    .card-value {
      font-size: 32px;
      font-weight: 800;
      margin-top: 8px;
    }

    /* Botones */
    .quick-actions {
      display: flex;
      gap: 12px;
      margin-top: 18px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 10px 14px;
      border-radius: 12px;
      font-weight: 700;
      border: 1px solid transparent;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
      color: #1f2933;
      box-shadow: 0 4px 12px rgba(252, 194, 0, 0.35);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(252, 194, 0, 0.45);
    }

    .btn-secondary {
      background: #ffffff;
      color: #1f2933;
      border-color: rgba(209, 213, 219, 1);
    }

    .btn-secondary:hover {
      background: #f3f4f6;
    }

    /* Grid inferior: dos columnas */
    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
    }
    @media (max-width: 1024px){ .grid-2 { grid-template-columns: 1fr; } }

    /* Encabezado panel blanco */
    .panel.card-panel .title h2 {
      font-size: 1rem;
      font-weight: 600;
      color: #111827;
    }

    .panel.card-panel .panel-header {
      margin-bottom: 0.75rem;
    }

    .panel.card-panel .panel-header .icon {
      width: 20px;
      height: 20px;
    }

    .panel.card-panel .link {
      font-size: 0.85rem;
      color: #2563eb;
      text-decoration: none;
    }

    .panel.card-panel .link:hover {
      text-decoration: underline;
    }

    /* Tablas */
    .table {
      margin-top: 10px;
    }

    .thead, .trow {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 10px;
      align-items: center;
    }

    .thead {
      color: #6b7280;
      font-weight: 600;
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 8px;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .trow {
      padding: 10px 0;
      border-bottom: 1px dashed #e5e7eb;
      font-size: 0.9rem;
    }

    .cell.strong {
      font-weight: 600;
      color: #111827;
    }

    .empty {
      opacity: .8;
      padding: 12px 0;
      font-size: 0.9rem;
      color: #6b7280;
    }

    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 12px;
    }

    .badge.active {
      background: #dcfce7;
      color: #166534;
    }

    .badge.inactive {
      background: #fee2e2;
      color: #b91c1c;
    }

    .state {
      font-weight: 600;
      font-size: 0.9rem;
    }

    .state.planificacion { color: #fbbf24; }
    .state.en_progreso   { color: #f97316; }
    .state.completada    { color: #22c55e; }
  </style>

  {{-- <div class="dashboard-wrapper"> --}}
        <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- ===== Panel principal / Hero ===== --}}
    <div class="panel panel-hero">
       
      <div class="panel-header">
        <div class="panel-header-main">
          <div class="title">
            📊
            <h1>Dashboard General</h1>
          </div>
          <p class="subtitle">Vista global de clientes y obras</p>
        </div>

          <div class="panel-header-actions">
            <a href="{{ route('works.create') }}" class="btn btn-primary">
              ➕ Nueva Obra
            </a>
            <a href="{{ route('clientes.create') }}" class="btn btn-secondary">
              ➕ Nuevo Cliente
            </a>
          </div>
        </div>


      {{-- Resumen --}}
      <div class="cards">
        <div class="card">
          <div class="card-head justify-between">
              <div class="card-title">
                👥 <span>Clientes Totales</span>
              </div>
              <strong class="card-number">{{ $clientsTotal }}</strong>
          </div>
        </div>


      <div class="card">
        <div class="card-head justify-between">
          <div class="card-title">👷🏼 <span>Clientes Activos</span></div>
          <strong class="card-number">{{ $clientsActive }}</strong>
        </div>
      </div>


      <div class="card">
        <div class="card-head justify-between">
          <div class="card-title">🏗️ <span>Obras Totales</span></div>
          <strong class="card-number">{{ $obrasTotal }}</strong>
        </div>
      </div>


      <div class="card">
        <div class="card-head justify-between">
          <div class="card-title">📊 <span>Obras en Progreso</span></div>
          <strong class="card-number">{{ $obrasProgress }}</strong>
        </div>
      </div>


       <div class="card">
        <div class="card-head justify-between">
          <div class="card-title">📋 <span>Planificación</span></div>
          <strong class="card-number">{{ $obrasPlanning }}</strong>
        </div>
      </div>

       <div class="card">
          <div class="card-head justify-between">
            <div class="card-title">🟢 <span>Completadas</span></div>
            <strong class="card-number">{{ $obrasCompleted }}</strong>
          </div>
        </div>


      {{-- Accesos rápidos --}}
      {{-- <div class="quick-actions">
        <a href="{{ route('works.create') }}" class="btn btn-primary">➕ Nueva Obra</a>
        <a href="{{ route('clientes.create') }}" class="btn btn-secondary">➕ Nuevo Cliente</a>
      </div> --}}
    </div>

    {{-- ===== Listados recientes ===== --}}
    <div class="grid-2" style="margin-top: 32px;">
      {{-- Últimas obras --}}
      
      <div class="panel card-panel">
        
        <div class="panel-header">
          <div class="title">
            <img src="{{ asset('assets/icons/clock.svg') }}" class="icon" alt="">
            <h2>Últimas Obras</h2>
          </div>
          <a class="link" href="{{ route('works.index') }}">Ver todas</a>
        </div>

        <div class="table">
          <div class="thead">
            <div>Obra</div>
            <div>Cliente</div>
            <div>Estado</div>
            <div>Creada</div>
          </div>
          @forelse(($latestObras  ?? []) as $obra)
            <div class="trow">
              <div class="cell strong">{{ $obra->name }}</div>
              <div class="cell">{{ $obra->cliente->name ?? '-' }}</div>
              <div class="cell state {{ $obra->estado }}">
                {{ ucfirst(str_replace('_',' ', $obra->status)) }}
              </div>
              <div class="cell">{{ $obra->created_at?->format('d/m/Y') }}</div>
            </div>
          @empty
            <div class="empty">Sin obras recientes.</div>
          @endforelse
        </div>
      </div>

      {{-- Últimos clientes --}}
      <div class="panel card-panel">
        <div class="panel-header">
          <div class="title">
            <img src="{{ asset('assets/icons/users.svg') }}" class="icon" alt="">
            <h2>Últimos Clientes</h2>
          </div>
          <a class="link" href="{{ route('clientes.index') }}">Ver todos</a>
        </div>

        <div class="table">
          <div class="thead">
            <div>Cliente</div>
            <div>Estatus</div>
            <div>Obras</div>
            <div>Creado</div>
          </div>
          @forelse(($latestClients  ?? []) as $cliente)
            <div class="trow">
              <div class="cell strong">{{ $cliente->name }}</div>
              <div class="cell badge {{ $cliente->status ?? 'inactive' }}">
                {{ $cliente->status === 'active' ? 'Activo' : 'Inactivo' }}
              </div>
              <div class="cell">{{ $cliente->obras_count ?? ($cliente->obras->count() ?? 0) }}</div>
              <div class="cell">{{ $cliente->created_at?->format('d/m/Y') }}</div>
            </div>
          @empty
            <div class="empty">Sin clientes recientes.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</x-app-layout>

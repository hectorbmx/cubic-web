<x-app-layout>
  {{-- Título para la pestaña --}}
  <x-slot name="title">Dashboard</x-slot>

  {{-- Estilos específicos de esta vista --}}
  {{-- @vite(['resources/css/dashboard/index.css']) --}}
  <style>
    .panel {
  background: linear-gradient(135deg, #22314a, #274061);
  color: #fff;
  padding: 22px;
  border-radius: 18px;
  box-shadow: 0 8px 24px rgba(0,0,0,.15);
  margin-bottom: 22px;
}

.panel .title { display:flex; align-items:center; gap:10px; }
.panel .title .icon { width:26px; height:26px; }
.panel .subtitle { margin-top:2px; opacity:.9; }

.cards {
  display:grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 16px;
  margin-top: 18px;
}
@media (max-width: 1024px){ .cards { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 640px){ .cards { grid-template-columns: 1fr; } }

.card {
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 12px;
  padding: 16px;
}
.card-head { display:flex; align-items:center; gap:10px; opacity:.95; }
.card-icon { width:22px; height:22px; }
.card-value { font-size: 32px; font-weight: 800; margin-top: 8px; }

.quick-actions { display:flex; gap:12px; margin-top:18px; flex-wrap:wrap; }
.btn { padding:10px 14px; border-radius: 12px; font-weight: 700; border:1px solid transparent; }
.btn-primary { background:#F6C147; color:#1e293b; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
.btn-secondary { background:#6CA2FF; color:#0b1220; }
.btn-outline { background:transparent; border-color: rgba(255,255,255,.35); color:#fff; }

.grid-2 {
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px;
}
@media (max-width: 1024px){ .grid-2 { grid-template-columns: 1fr; } }

.table { margin-top: 10px; }
.thead, .trow {
  display:grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 10px;
  align-items:center;
}
.thead {
  color: rgba(255,255,255,.85);
  font-weight: 700;
  border-bottom: 1px solid rgba(255,255,255,.18);
  padding-bottom: 8px;
}
.trow {
  padding: 10px 0;
  border-bottom: 1px dashed rgba(255,255,255,.15);
}
.cell.strong { font-weight: 700; }
.empty { opacity:.8; padding: 8px 0; }

.badge { display:inline-block; padding:2px 8px; border-radius: 999px; font-size: 12px; }
.badge.active { background: #10b981; color:#042b1f; }
.badge.inactive { background:#94a3b8; color:#0b1220; }

.state { font-weight:700; }
.state.planificacion { color:#fbbf24; }
.state.en_progreso { color:#f59e0b; }
.state.completada { color:#34d399; }

  </style>

  {{-- ===== Panel principal ===== --}}

  <div class="panel">
    <div class="panel-header">
      <div class="title">
        {{-- <img src="{{ asset('assets/icons/overview.svg') }}" alt="" class="icon"> --}}
        📊
        <h1>Dashboard General</h1>
      </div>
      <p class="subtitle">Vista global de clientes y obras</p>
    </div>

    {{-- ===== Resumen ===== --}}
    <div class="cards">
      <div class="card">
        <div class="card-head">
          {{-- <img src="{{ asset('assets/icons/clients.svg') }}" class="card-icon" alt=""> --}}
          👥 
          <span>Clientes Totales</span>
        </div>
        
        <div class="card-value">{{ $clientsTotal }}</div>
      </div>

      <div class="card">
        <div class="card-head">
          {{-- <img src="{{ asset('assets/icons/active.svg') }}" class="card-icon" alt=""> --}}
          👷🏼
          
          <span>Clientes Activos</span>
        </div>
        
        <div class="card-value">{{ $clientsActive }}</div>
      </div>

      <div class="card">
        <div class="card-head">
          {{-- <img src="{{ asset('assets/icons/obras.svg') }}" class="card-icon" alt=""> --}}
          🏗️
          <span>Obras Totales</span>
        </div>
        <div class="card-value">{{ $obrasTotal }}</div>
      </div>

      <div class="card">
        <div class="card-head">
          {{-- <img src="{{ asset('assets/icons/progress.svg') }}" class="card-icon" alt=""> --}}
          📊
          <span>Obras en Progreso</span>
        </div>
        <div class="card-value">{{ $obrasProgress }}</div>
      </div>

      <div class="card">
        <div class="card-head">
          {{-- <img src="{{ asset('assets/icons/plan.svg') }}" class="card-icon" alt=""> --}}
          📋
          <span>Planificación</span>
        </div>
        <div class="card-value">{{ $obrasPlanning }}</div>
      </div>

      <div class="card">
        <div class="card-head">
          🟢
          <span>Completadas</span>
        </div>
        <div class="card-value">{{ $obrasCompleted }}</div>
      </div>
    </div>

    {{-- ===== Accesos rápidos ===== --}}
    <div class="quick-actions">
      <a href="{{ route('works.create') }}" class="btn btn-primary">➕ Nueva Obra</a>
      <a href="{{ route('clientes.create') }}" class="btn btn-secondary">➕ Nuevo Cliente</a>
      {{-- <a href="{{ route('dashboard.reportes') }}" class="btn btn-outline">📊 Reportes</a> --}}
    </div>
  </div>

  {{-- ===== Listados recientes ===== --}}
  <div class="grid-2">
    <div class="panel">
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

    <div class="panel">
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
  
</x-app-layout>

<x-app-layout>
    <style>
        .client-detail-page {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 28px;
            color: #2c4a6b;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            color: #2c4a6b;
            box-shadow: 0 2px 8px rgba(252, 194, 0, 0.25);
        }

        .btn-edit {
            background: #2c4a6b;
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #2c4a6b;
            border: 2px solid #e5e7eb;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            width: 140px;
            font-size: 14px;
        }

        .info-value {
            flex: 1;
            color: #374151;
            font-size: 14px;
        }

        .obras-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .obra-item {
            padding: 1rem;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .obra-item:hover {
            border-color: #FCC200;
            background: white;
            transform: translateX(4px);
        }

        .obra-name {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .obra-meta {
            display: flex;
            gap: 1rem;
            font-size: 13px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .user-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #2c4a6b;
            margin-right: 0.75rem;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #2c4a6b;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="client-detail-page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Mensajes --}}
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header --}}
                <div class="page-header">
                    <div>
                        <h1>{{ $cliente->name }}</h1>
                        @if($cliente->company)
                            <p class="subtitle">{{ $cliente->company }}</p>
                        @endif
                    </div>
                    <div class="header-actions">
                        @can('update', $cliente)
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-edit">
                                ✏️ Editar
                            </a>
                        @endcan
                        <a href="{{ route('works.create') }}?client_id={{ $cliente->id }}" class="btn btn-primary">
                            🏗️ Nueva Obra
                        </a>
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                            ← Volver
                        </a>
                    </div>
                </div>

                {{-- Content Grid --}}
                <div class="content-grid">
                    {{-- Columna Principal --}}
                    <div>
                        {{-- Información del Cliente --}}
                        <div class="info-card text-dark">
                            <h2 class="card-title">Información del Cliente</h2>
                            
                            <div class="info-row">
                                <span class="info-label">Nombre:</span>
                                <span class="info-value">{{ $cliente->name }}</span>
                            </div>

                            @if($cliente->company)
                                <div class="info-row">
                                    <span class="info-label">Empresa:</span>
                                    <span class="info-value">{{ $cliente->company }}</span>
                                </div>
                            @endif

                            @if($cliente->email)
                                <div class="info-row">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">
                                        <a href="mailto:{{ $cliente->email }}" style="color: #2c4a6b;">{{ $cliente->email }}</a>
                                    </span>
                                </div>
                            @endif

                            @if($cliente->phone)
                                <div class="info-row">
                                    <span class="info-label">Teléfono:</span>
                                    <span class="info-value">
                                        <a href="tel:{{ $cliente->phone }}" style="color: #2c4a6b;">{{ $cliente->phone }}</a>
                                    </span>
                                </div>
                            @endif

                            @if($cliente->rfc)
                                <div class="info-row">
                                    <span class="info-label">RFC:</span>
                                    <span class="info-value">{{ $cliente->rfc }}</span>
                                </div>
                            @endif

                            @if($cliente->contact_person)
                                <div class="info-row">
                                    <span class="info-label">Contacto:</span>
                                    <span class="info-value">{{ $cliente->contact_person }}</span>
                                </div>
                            @endif

                            @if($cliente->address)
                                <div class="info-row">
                                    <span class="info-label">Dirección:</span>
                                    <span class="info-value">{{ $cliente->address }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Obras --}}
                        <div class="info-card text-dark">
                            <h2 class="card-title">
                                Obras ({{ $cliente->obras->count() }})
                            </h2>

                            @if($cliente->obras->count() > 0)
                                <div class="obras-list">
                                    @foreach($cliente->obras as $obra)
                                        <a href="{{ route('works.show', $obra) }}" class="obra-item">
                                            <div class="obra-name">{{ $obra->name }}</div>
                                            <div class="obra-meta">
                                                <span>Código: {{ $obra->code }}</span>
                                                <span>
                                                    @php
                                                        $statusColors = [
                                                            'planning' => 'badge-blue',
                                                            'in_progress' => 'badge-green',
                                                            'paused' => 'badge-yellow',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$obra->status] ?? 'badge-blue' }}">
                                                        {{ $obra->status_formatted }}
                                                    </span>
                                                </span>
                                                <span>Progreso: {{ $obra->progress_pct }}%</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">🏗️</div>
                                    <p>No hay obras registradas para este cliente</p>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                                        <a href="{{ route('works.create') }}?client_id={{ $cliente->id }}" class="btn btn-primary" style="margin-top: 1rem;">
                                            Crear Primera Obra
                                        </a>
                                    @endif
                                </div>

                            @endif
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div>
                        {{-- Usuarios Asignados --}}
                       <div class="info-card">
  <div class="info-card bg-white rounded-3 shadow-sm p-4 text-dark">

    <h2 class="card-title m-0">Usuarios & invitaciones</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInvitarUsuario">
      Invitar usuario
    </button>
  </div>
  <div class="card-body p-0 bg-white rounded-3 shadow-sm p-4">
    <!-- Lista de usuarios -->
    @if(($cliente->usuarios ?? collect())->count())
      <div class="table-responsive">
        <table class="table mb-0 text-gray-800">
          <thead>
            <tr >
              <th>Usuario</th>
              <th>Rol (cliente)</th>
              <th>Estado</th>
              {{-- <th>Invitado por</th> --}}
              <th>Invitado el</th>
              <th>Acceso</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
          @foreach($cliente->usuarios as $u)
            <tr>
              <td>{{ $u->name }} <div class="text-muted small">{{ $u->email }}</div></td>
              <td><span class="badge bg-secondary">{{ $u->pivot->role ?? '—' }}</span></td>
              <td>
                @php $st = $u->pivot->status ?? '—'; @endphp
                <span class="badge {{ $st === 'active' ? 'bg-success' : ($st === 'invited' ? 'bg-warning' : 'bg-secondary') }}">
                  {{ $st }}
                </span>
              </td>
              {{-- <td class="small text-muted">{{ $u->pivot->invited_by_user_id ? 'User #'.$u->pivot->invited_by_user_id : '—' }}</td> --}}
              <td class="small text-muted">{{ $u->pivot->invited_at ? $u->pivot->invited_at : '—' }}</td>
              <td class="small">
                {{-- Global vs por obras (simple, luego afinamos) --}}
                @if(($u->pivot->role ?? '') === 'company_admin')
                  Todas las obras
                @else
                  Seleccionadas
                @endif
              </td>
              <td class="text-end">
                {{-- Botones futuros: Ver obras, Cambiar rol, Reenviar, Suspender, Revocar --}}
                <div class="btn-group">
              <a href="{{ route('usuarios.obras', $u->id) }}"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ver obras
                </a>
                  <button class="btn btn-sm btn-outline-secondary" disabled>Editar</button>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="p-4 text-center text-muted">
        Aún no hay usuarios vinculados a este cliente.
      </div>
    @endif
  </div>
</div>
{{-- Modal Invitar Usuario --}}
<div class="modal fade text-dark" id="modalInvitarUsuario" tabindex="-1" aria-hidden="true"> 
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('clientes.invitaciones.store', $cliente) }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Invitar usuario al cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Correo del usuario</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Rol a nivel cliente</label>
          <select name="role" class="form-select" required>
            <option value="company_admin">Company admin (todas las obras)</option>
            <option value="gestor">Gestor</option>
            <option value="viewer">Viewer</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Alcance</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="scope" id="scope-global" value="global" checked>
            <label class="form-check-label" for="scope-global">Acceso global a todas las obras</label>
          </div>
          <div class="form-check mt-1">
            <input class="form-check-input" type="radio" name="scope" id="scope-partial" value="partial">
            <label class="form-check-label" for="scope-partial">Seleccionar obras específicas</label>
          </div>
        </div>

        <div class="mb-3" id="select-obras" style="display:none;">
          <label class="form-label">Obras del cliente</label>
          <select name="obras[]" class="form-select" multiple size="6">
            @foreach($cliente->obras as $obra)
              <option value="{{ $obra->id }}">{{ $obra->name ?? ('Obra #'.$obra->id) }}</option>
            @endforeach
          </select>
          <div class="form-text">Mantén Ctrl/Cmd para seleccionar varias.</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar invitación</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('change', function(e){
  if(e.target && (e.target.id === 'scope-global' || e.target.id === 'scope-partial')){
    document.getElementById('select-obras').style.display =
      document.getElementById('scope-partial').checked ? 'block' : 'none';
  }
});
</script>

{{-- termina modal invitar usario --}}


                        {{-- Estadísticas --}}
                        <div class="info-card text-dark">
                            <h2 class="card-title">Estadísticas</h2>
                            
                            <div class="info-row">
                                <span class="info-label">Total obras:</span>
                                <span class="info-value">{{ $cliente->obras->count() }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Obras activas:</span>
                                <span class="info-value">{{ $cliente->obrasActivas->count() }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Obras completadas:</span>
                                <span class="info-value">{{ $cliente->obrasCompletadas->count() }}</span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Registrado:</span>
                                <span class="info-value">{{ $cliente->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
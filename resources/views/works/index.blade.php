<x-app-layout>
    <style>
        .obras-index-container {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Header Principal */
      .page-header {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        .header-title-section h1 {
            font-size: 28px; /* Reducido un poco */
            font-weight: 700;
            margin: 0 0 0.35rem 0;
        }
        .header-title-section .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0; /* Evita que se compriman */
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Estadísticas */
      /* Estadísticas */
.stats-grid {
    display: flex;
    gap: 1rem;
    margin-top: 0rem;
    flex-wrap: wrap;
}

.stat-card {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 0.75rem 1.25rem; /* ← Reducido de 1.5rem */
    display: flex;
    align-items: center;
    gap: 0.75rem; /* ← Reducido de 1rem */
    flex: 1;
    min-width: 150px; /* ← Ancho mínimo más pequeño */
}

.stat-icon {
    font-size: 24px; /* ← Reducido de 32px */
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 11px; /* ← Reducido de 12px */
    opacity: 0.8;
    margin-bottom: 0.15rem; /* ← Reducido de 0.25rem */
    line-height: 1.2;
}

.stat-value {
    font-size: 22px; /* ← Reducido de 28px */
    font-weight: 700;
    line-height: 1;
}

        /* Botones */
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
            background: #FCC200;
            color: #2c4a6b;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Filtros */
        .filters-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input, .form-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
            color: #374151;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #FCC200;
            background: white;
        }

        /* Tabla */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            color: white;
        }

        .data-table th {
            text-align: left;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .data-table td {
            padding: 1.25rem 1.5rem;
            font-size: 14px;
            color: #374151;
        }

        /* Obra Info */
        .obra-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #2c4a6b;
            font-size: 13px;
        }

        .obra-name {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .obra-address {
            font-size: 13px;
            color: #6b7280;
        }

        /* Progress Bar */
        .progress-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .progress-bar-container {
            flex: 1;
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #FCC200 0%, #f5b800 100%);
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            min-width: 40px;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-planning { background: #dbeafe; color: #1e40af; }
        .badge-in_progress { background: #d1fae5; color: #065f46; }
        .badge-paused { background: #fef3c7; color: #92400e; }
        .badge-completed { background: #e5e7eb; color: #374151; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            padding: 0.5rem;
            border-radius: 8px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: #2c4a6b;
            border-color: #2c4a6b;
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* Pagination */
        .pagination-container {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
    </style>

    <div class="obras-index-container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Mensajes --}}
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header --}}
             {{-- Header --}}
<div class="page-header">
    <div class="header-top">
        <div class="header-title-section">
            <h1>🏗️ Gestión de Obras</h1>
            <p class="subtitle">Administra y supervisa todas las obras del sistema</p>
        </div>
        <div class="header-actions">
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
            <a href="{{ route('works.create') }}" class="btn btn-primary">
                ➕ Nueva Obra
            </a>
            @endif
            <a href="{{ route('works.dashboard') }}" class="btn btn-secondary">
                📊 Dashboard
            </a>
        </div>
    </div>
    
    {{-- Estadísticas --}}
    <div class="stats-grid">
       @php
            $totalObras = $stats['total'];
            $enPlanificacion = $stats['planning'];
            $enProgreso = $stats['in_progress'];
            $pausadas = $stats['paused'];
            $completadas = $stats['completed'];
        @endphp
        
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <div class="stat-label">Total Obras</div>
                <div class="stat-value">{{ $totalObras }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-info">
                <div class="stat-label">Planificación</div>
                <div class="stat-value">{{ $enPlanificacion }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🚧</div>
            <div class="stat-info">
                <div class="stat-label">En Progreso</div>
                <div class="stat-value">{{ $enProgreso }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⏸️</div>
            <div class="stat-info">
                <div class="stat-label">Pausadas</div>
                <div class="stat-value">{{ $pausadas }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <div class="stat-label">Completadas</div>
                <div class="stat-value">{{ $completadas }}</div>
            </div>
        </div>
    </div>
</div>

                {{-- Filtros --}}
                <div class="filters-container">
                    <form action="{{ route('works.search') }}" method="GET">
                        <div class="filters-grid">
                            <div class="form-group">
                                <label class="form-label">🔍 Buscar</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="form-input" placeholder="Nombre, código o dirección...">
                            </div>

                            <div class="form-group">
                                <label class="form-label">🎯 Estado</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planificación</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                    <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Pausada</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">🏢 Cliente</label>
                                <select name="client_id" class="form-select">
                                    <option value="">Todos los clientes</option>
                                    @foreach(App\Models\Cliente::orderBy('name')->get() as $cliente)
                                        <option value="{{ $cliente->id }}" {{ request('client_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    Buscar
                                </button>
                                <a href="{{ route('works.index') }}" class="btn btn-secondary">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Tabla de Obras --}}
                <div class="table-container">
                    @if($obras->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Obra</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Progreso</th>
                                    <th>Fechas</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $obra)
                                    <tr>
                                        <td>
                                            <span class="obra-code">{{ $obra->code }}</span>
                                        </td>
                                        <td>
                                            <div class="obra-name">{{ $obra->name }}</div>
                                            @if($obra->address)
                                                <div class="obra-address">📍 {{ Str::limit($obra->address, 40) }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #2c4a6b;">
                                                {{ $obra->cliente->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = [
                                                    'planning' => 'badge-planning',
                                                    'in_progress' => 'badge-in_progress',
                                                    'paused' => 'badge-paused',
                                                    'completed' => 'badge-completed',
                                                    'cancelled' => 'badge-cancelled',
                                                ][$obra->status] ?? 'badge-planning';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $obra->status_formatted }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar-fill" style="width: {{ $obra->progress_pct }}%"></div>
                                                </div>
                                                <span class="progress-text">{{ $obra->progress_pct }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($obra->start_date)
                                                <div style="font-size: 13px; color: #6b7280;">
                                                    <div>📅 {{ $obra->start_date->format('d/m/Y') }}</div>
                                                    @if($obra->end_date)
                                                        <div>🏁 {{ $obra->end_date->format('d/m/Y') }}</div>
                                                    @endif
                                                </div>
                                            @else
                                                <span style="color: #9ca3af; font-size: 13px;">Sin fechas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons" style="justify-content: center;">
                                                <a href="{{ route('works.show', $obra) }}" class="btn-icon" title="Ver detalles">
                                                    👁️
                                                </a>
                                                <a href="{{ route('works.edit', $obra) }}" class="btn-icon" title="Editar">
                                                    ✏️
                                                </a>
                                                <form action="{{ route('works.destroy', $obra) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon" 
                                                            onclick="return confirm('¿Eliminar esta obra?')" 
                                                            title="Eliminar">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Paginación --}}
                        <div class="pagination-container">
                            {{ $obras->links() }}
                        </div>
                    @else
                    @if(auth()->user()->hasRole(['admin', 'superadmin']))
                        <div class="empty-state">
                            <div class="empty-icon">🏗️</div>
                            <h3 style="font-size: 20px; color: #374151; margin-bottom: 0.5rem;">No hay obras registradas</h3>
                            <p style="margin-bottom: 2rem;">Comienza creando tu primera obra</p>
                            <a href="{{ route('works.create') }}" class="btn btn-primary">
                                ➕ Crear Primera Obra
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
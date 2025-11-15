<x-app-layout>
    <style>
        .obras-cliente-page {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .page-hero {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 1.25rem 1.75rem; /* ← Aún más reducido */
            border-radius: 16px;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* ← Cambiado de center */
            gap: 2rem;
        }

        .hero-left {
            flex: 1;
        }

        .hero-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .hero-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .hero-title h1 {
            font-size: 24px; /* ← Reducido de 32px */
            font-weight: 700;
            margin: 0;
        }

       .hero-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 0.25rem;
        }

        .client-meta {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .client-meta-item {
           display: flex;
            align-items: center;
            gap: 0.35rem; /* ← Reducido de 0.5rem */
            font-size: 13px; /* ← Reducido de 14px */
        }


        .obras-badge {
           background: #FCC200;
            color: #2c4a6b;
            padding: 0.35rem 0.85rem; /* ← Reducido de 0.5rem 1rem */
            border-radius: 8px; /* ← Reducido de 10px */
            font-weight: 600;
            font-size: 13px; /* ← Reducido de 14px */
            display: inline-block;
            margin-top: 0.75rem; /* ← Reducido de 1rem */
        }

       .btn {
            padding: 0.6rem 1.25rem; /* ← Reducido de 0.75rem 1.5rem */
            border-radius: 8px; /* ← Reducido de 10px */
            font-weight: 600;
            font-size: 13px; /* ← Reducido de 14px */
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem; /* ← Reducido de 0.5rem */
        }

        .btn-primary {
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            color: #2c4a6b;
            box-shadow: 0 2px 8px rgba(252, 194, 0, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(252, 194, 0, 0.35);
        }

        .btn-secondary {
            background: white;
            color: #2c4a6b;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

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
            background: #2c4a6b;
            color: white;
        }

        .data-table th {
            text-align: left;
            padding: 1rem 1.5rem;
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

        .obra-name {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .obra-location {
            color: #6b7280;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-planning { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #d1fae5; color: #065f46; }
        .status-paused { background: #fef3c7; color: #92400e; }
        .status-completed { background: #e5e7eb; color: #374151; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .progress-cell {
            min-width: 120px;
        }

        .progress-bar-small {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .progress-fill-small {
            height: 100%;
            background: linear-gradient(90deg, #FCC200, #f5b800);
        }

        .progress-text-small {
            font-size: 12px;
            color: #6b7280;
        }

        .date-display {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 13px;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .actions-cell {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 13px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.2s ease;
            border: 1.5px solid;
        }

        .btn-view {
            background: white;
            color: #2c4a6b;
            border-color: #d1d5db;
        }

        .btn-view:hover {
            background: #2c4a6b;
            color: white;
            border-color: #2c4a6b;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        .btn-edit:hover {
            background: #fde68a;
            border-color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-container {
                overflow-x: auto;
            }

            .data-table {
                min-width: 900px;
            }
        }
    </style>

    <div class="obras-cliente-page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                
                {{-- Hero Header --}}
            {{-- Hero Header --}}
<div class="page-hero">
    <div class="hero-content">
        <div class="hero-left">
            <h1 class="hero-title">🏢 {{ $cliente->name }}</h1>
            <p class="hero-subtitle">Todas las obras asignadas a este cliente</p>
            <div class="client-meta">
                @if($cliente->email)
                    <div class="client-meta-item">
                        <span>📧</span>
                        <span>{{ $cliente->email }}</span>
                    </div>
                @endif
                @if($cliente->phone)
                    <div class="client-meta-item">
                        <span>📞</span>
                        <span>{{ $cliente->phone }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="hero-right">
            <span class="obras-badge">📊 {{ $obras->count() }} obra(s) registrada(s)</span>
            <div style="display: flex; gap: 0.75rem; margin-top: 0.75rem;">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    ← Volver a Clientes
                </a>
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                <a href="{{ route('works.create', ['client_id' => $cliente->id]) }}" class="btn btn-primary">
                    ➕ Nueva Obra
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

                {{-- Obras Table --}}
                @if($obras->count() > 0)
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>OBRA</th>
                                    <th>RESPONSABLE</th>
                                    <th>ESTADO</th>
                                    <th>PROGRESO</th>
                                    <th>FECHAS</th>
                                    <th style="text-align: right;">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $obra)
                                    <tr>
                                        <td style="font-weight: 600; color: #2c4a6b;">
                                            {{ $obra->code }}
                                        </td>
                                        <td>
                                            <div class="obra-name">{{ $obra->name }}</div>
                                            @if($obra->address)
                                                <div class="obra-location">
                                                    <span>📍</span>
                                                    <span>{{ Str::limit($obra->address, 40) }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $obra->usuario->name ?? 'Sin asignar' }}
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $obra->status }}">
                                                @switch($obra->status)
                                                    @case('planning') Planificación @break
                                                    @case('in_progress') En Progreso @break
                                                    @case('paused') Pausada @break
                                                    @case('completed') Completada @break
                                                    @case('cancelled') Cancelada @break
                                                @endswitch
                                            </span>
                                        </td>
                                        <td class="progress-cell">
                                            <div class="progress-bar-small">
                                                <div class="progress-fill-small" style="width: {{ $obra->progress_pct }}%"></div>
                                            </div>
                                            <div class="progress-text-small">{{ $obra->progress_pct }}%</div>
                                        </td>
                                        <td>
                                            @if($obra->start_date)
                                                <div class="date-display">
                                                    <span>📅</span>
                                                    <span>{{ $obra->start_date->format('d/m/Y') }}</span>
                                                </div>
                                            @endif
                                            @if($obra->end_date)
                                                <div class="date-display">
                                                    <span>🏁</span>
                                                    <span>{{ $obra->end_date->format('d/m/Y') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions-cell">
                                                <a href="{{ route('works.show', $obra) }}" class="btn-action btn-view">
                                                    👁️ Ver
                                                </a>
                                                <a href="{{ route('works.edit', $obra) }}" class="btn-action btn-edit">
                                                    ✏️ Editar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="table-container">
                        <div class="empty-state">
                            <div class="empty-state-icon">🏗️</div>
                            <h3>No hay obras registradas</h3>
                            <p>Este cliente aún no tiene obras asignadas</p>
                          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                                <a href="{{ route('works.create') }}?client_id={{ $cliente->id }}" class="btn btn-primary" style="margin-top: 1rem;">
                                    Crear Primera Obra
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
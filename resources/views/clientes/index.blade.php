<x-app-layout>

    <style>
        .clientes-page {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .page-hero {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 2rem;
            border-radius: 16px;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .hero-title h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
    margin-top: 1.5rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.25rem 1.5rem; /* ← Más horizontal */
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.stat-icon {
    font-size: 28px;
    flex-shrink: 0;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    line-height: 1;
    flex-shrink: 0;
}

.stat-label {
    font-size: 13px;
    opacity: 0.9;
    line-height: 1.3;
    flex: 1; /* ← Toma el espacio restante */
}


        .btn-primary {
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            color: #2c4a6b;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(252, 194, 0, 0.25);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(252, 194, 0, 0.35);
        }

        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            background: #f9fafb;
        }

        .search-box input:focus {
            outline: none;
            border-color: #FCC200;
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
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

        .client-name {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .client-email {
            color: #6b7280;
            font-size: 13px;
        }

        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
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

        .btn-obras {
            background: #e0e7ff;
            color: #3730a3;
            border-color: #c7d2fe;
        }

        .btn-obras:hover {
            background: #c7d2fe;
            border-color: #3730a3;
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
        .btn-ver {
            background: #a0f7b3;
            color: #92400e;
            border-color: #32f15b;
        }

        .btn-add {
            background: #2c4a6b;
            color: white;
            border-color: #2c4a6b;
        }

        .btn-add:hover {
            background: #1e3449;
            border-color: #1e3449;
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
            font-size: 20px;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
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

            .actions {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="clientes-page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Hero Header --}}
                <div class="page-hero">
                    <div class="hero-content">
                        <div class="hero-title">
                            <h1>👥 Gestión de Clientes</h1>
                        </div>
                        @if(auth()->user()->hasAnyRole(['admin', 'superadmin']))
                        <a href="{{ route('clientes.create') }}" class="btn-primary">
                            ➕ Nuevo Cliente
                        </a>
                        @endif
                    </div>
                    <p class="hero-subtitle">Administra y supervisa todos los clientes del sistema</p>

                    {{-- Stats Grid --}}
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">📊</div>
                            <div class="stat-value">{{ $clientes->total() }}</div>
                            <div class="stat-label">Total Clientes</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">✅</div>
                            <div class="stat-value">{{ $clientes->where('status', 'active')->count() }}</div>
                            <div class="stat-label">Activos</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">🏗️</div>
                            <div class="stat-value">{{ $clientes->sum('obras_activas_count') }}</div>
                            <div class="stat-label">Obras Totales</div>
                        </div>
                    </div>
                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Table Container --}}
                <div class="table-container">
                    <div class="table-header">
                        <form action="{{ route('clientes.index') }}" method="GET" class="search-box">
                            <span class="search-icon">🔍</span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Buscar clientes por nombre, email o teléfono...">
                        </form>
                    </div>

                    @if($clientes->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>CLIENTE</th>
                                    <th>TELÉFONO</th>
                                    <th>OBRAS ACTIVAS</th>
                                    <th>ESTADO</th>
                                    <th style="text-align: right;">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td>
                                            <div class="client-name">{{ $cliente->name }}</div>
                                            <div class="client-email">{{ $cliente->email ?? 'Sin email' }}</div>
                                        </td>
                                        <td>{{ $cliente->phone ?? 'N/A' }}</td>
                                        <td>{{ $cliente->obras_activas_count ?? 0 }} obras</td>
                                        <td>
                                            @if(($cliente->obras_activas_count ?? 0) > 0)
                                                <span class="badge badge-active">Activo</span>
                                            @else
                                                <span class="badge badge-inactive">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('clientes.obras', $cliente) }}" class="btn-action btn-obras">
                                                    📋 Obras
                                                </a>
                                                @if(auth()->user()->hasAnyRole(['admin', 'superadmin']))
                                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn-action btn-edit">
                                                    ✏️ Editar
                                                </a>
                                                @endif
                                                @if(auth()->user()->hasAnyRole(['admin', 'superadmin']))
                                                <a href="{{ route('works.create') }}?client_id={{ $cliente->id }}" class="btn-action btn-add">
                                                    ➕ Agregar Obra
                                                </a>
                                                @endif
                                                @if(auth()->user()->roles->count() > 0 && auth()->user()->hasAnyRole(['admin', 'superadmin']))
                                                 <a href="{{ route('clientes.show', $cliente) }}" class="btn-icon btn-primary" title="Ver detalles">
                                                    👁️ Ver Cliente
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="p-6 border-t border-gray-200">
                            {{ $clientes->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">👥</div>
                            <h3>No hay clientes registrados</h3>
                            <p>Comienza agregando tu primer cliente</p>
                            <a href="{{ route('clientes.create') }}" class="btn-primary">
                                ➕ Agregar Primer Cliente
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
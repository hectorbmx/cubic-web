<x-app-layout>
    <style>
        .usuarios-obras-page {
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

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .stat-label {
            font-size: 13px;
            opacity: 0.8;
            margin-top: 0.25rem;
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

        .btn-secondary {
            background: white;
            color: #2c4a6b;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
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

        .obra-address {
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

        .badge-planning {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-in_progress {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-on_hold {
            background: #f3f4f6;
            color: #374151;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-admin {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-gestor {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-viewer {
            background: #f3f4f6;
            color: #374151;
        }

        .progress-bar-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            max-width: 100px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 13px;
            color: #6b7280;
            min-width: 40px;
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
            background: #e0e7ff;
            color: #3730a3;
            border-color: #c7d2fe;
        }

        .btn-action:hover {
            background: #c7d2fe;
            border-color: #3730a3;
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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: border-color 0.2s;
    background-color: white !important;
    color: #374151 !important;
}

.form-control option {
    background-color: white !important;
    color: #374151 !important;
}
        .form-control:focus {
            outline: none;
            border-color: #FCC200;
        }

        .obras-list {
            max-height: 400px;
            overflow-y: auto;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 1rem;
        }

        .obra-checkbox {
            display: flex;
            align-items: start;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .obra-checkbox:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .obra-checkbox.disabled {
            background: #f3f4f6;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .obra-checkbox input[type="checkbox"] {
            margin-right: 1rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .obra-checkbox-label {
            flex: 1;
        }

        .obra-checkbox-title {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .obra-checkbox-meta {
            font-size: 13px;
            color: #6b7280;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
    </style>

    <div class="usuarios-obras-page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Hero Header --}}
                <div class="page-hero">
                    <div class="hero-content">
                        <div class="hero-title">
                            <h1>👤 Obras de {{ $user->name }}</h1>
                        </div>
                        <div style="display: flex; gap: 0.75rem;">
                            <button onclick="openModal()" class="btn-primary">
                                ➕ Asignar a Nueva Obra
                            </button>
                            <a href="{{ url()->previous() }}" class="btn-secondary">
                                ← Volver
                            </a>
                        </div>
                    </div>
                    <p class="hero-subtitle">Gestión de obras asignadas al usuario</p>

                    {{-- Stats Grid --}}
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">📧</div>
                            <div class="stat-label">Email</div>
                            <div style="font-size: 14px; margin-top: 0.5rem; word-break: break-all;">{{ $user->email }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">🏢</div>
                            <div class="stat-value">{{ $user->clientes->count() }}</div>
                            <div class="stat-label">Clientes</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">🏗️</div>
                            <div class="stat-value">{{ $obras->total() }}</div>
                            <div class="stat-label">Obras Asignadas</div>
                        </div>
                    </div>
                </div>

                {{-- Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <span style="font-size: 20px;">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <span style="font-size: 20px;">⚠</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Table Container --}}
                <div class="table-container">
                    @if($obras->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>OBRA</th>
                                    <th>CLIENTE</th>
                                    <th>ESTADO</th>
                                    <th>ROL</th>
                                    <th>PROGRESO</th>
                                    <th style="text-align: center;">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $obra)
                                    <tr>
                                        <td>
                                            <span class="badge" style="background: #f3f4f6; color: #374151;">
                                                {{ $obra->code ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="obra-name">{{ $obra->name }}</div>
                                            <div class="obra-address">📍 {{ Str::limit($obra->address ?? 'Sin dirección', 40) }}</div>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span>🏢</span>
                                                <span>{{ $obra->cliente->name ?? 'Sin cliente' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusLabels = [
                                                    'planning' => 'Planificación',
                                                    'in_progress' => 'En Progreso',
                                                    'completed' => 'Completada',
                                                    'on_hold' => 'En Pausa',
                                                    'cancelled' => 'Cancelada',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $obra->status }}">
                                                {{ $statusLabels[$obra->status] ?? $obra->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $roleLabels = [
                                                    'company_admin' => 'Administrador',
                                                    'gestor' => 'Gestor',
                                                    'viewer' => 'Visualizador',
                                                ];
                                                $roleClass = [
                                                    'company_admin' => 'admin',
                                                    'gestor' => 'gestor',
                                                    'viewer' => 'viewer',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $roleClass[$obra->pivot->role ?? ''] ?? 'viewer' }}">
                                                {{ $roleLabels[$obra->pivot->role ?? ''] ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress-bar-container">
                                                <div class="progress-bar">
                                                    <div class="progress-fill" style="width: {{ $obra->progress ?? 0 }}%"></div>
                                                </div>
                                                <span class="progress-text">{{ $obra->progress ?? 0 }}%</span>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('works.show', $obra) }}" class="btn-action">
                                                👁️ Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div style="padding: 1.5rem; border-top: 1px solid #f3f4f6;">
                            {{ $obras->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <h3>No hay obras asignadas</h3>
                            <p>Este usuario no tiene obras asignadas aún.</p>
                            <button onclick="openModal()" class="btn-primary">
                                ➕ Asignar Primera Obra
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="asignarObraModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>👤 Asignar Usuario a Obras</h3>
                <button onclick="closeModal()" class="modal-close">×</button>
            </div>
            
            <form action="{{ route('usuarios.obras.asignar', $user) }}" method="POST">
                @csrf
                
                <div class="modal-body">
                    <div class="alert alert-info">
                        <span style="font-size: 20px;">ℹ️</span>
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <small>{{ $user->email }}</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-dark">🔑 Rol del usuario en las obras seleccionadas</label>
                        <select name="role" required class="form-control text-dark">
                            <option value="">Seleccionar rol...</option>
                            <option value="manager">Administrador (acceso total)</option>
                            <option value="residente">Gestor (puede editar)</option>
                            <option value="viewer_obra">Visualizador (solo lectura)</option>
                        </select>
                        <small style="color: #6b7280; font-size: 13px; margin-top: 0.5rem; display: block;">
                            El rol determina los permisos del usuario en las obras
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">🏗️ Seleccionar obras</label>
                        <div class="obras-list">
                            @php
                                $obrasAsignadas = $user->obras->pluck('id')->toArray();
                            @endphp

                            @forelse($obrasDisponibles as $obraDisponible)
                                @php
                                    $isAsignada = in_array($obraDisponible->id, $obrasAsignadas);
                                @endphp
                                <div class="obra-checkbox {{ $isAsignada ? 'disabled' : '' }}">
                                    <input 
                                        type="checkbox" 
                                        name="obras[]" 
                                        value="{{ $obraDisponible->id }}"
                                        id="obra_{{ $obraDisponible->id }}"
                                        {{ $isAsignada ? 'checked disabled' : '' }}
                                    >
                                    <label class="obra-checkbox-label" for="obra_{{ $obraDisponible->id }}">
                                        <div class="obra-checkbox-title">
                                            {{ $obraDisponible->name }}
                                            @if($isAsignada)
                                                <span class="badge" style="background: #d1fae5; color: #065f46; margin-left: 0.5rem;">
                                                    ✓ Ya asignada
                                                </span>
                                            @endif
                                        </div>
                                        <div class="obra-checkbox-meta">
                                            🏢 {{ $obraDisponible->cliente->name ?? 'Sin cliente' }}
                                        </div>
                                        @if($obraDisponible->address)
                                            <div class="obra-checkbox-meta">
                                                📍 {{ Str::limit($obraDisponible->address, 50) }}
                                            </div>
                                        @endif
                                    </label>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">📦</div>
                                    <p>No hay obras disponibles para asignar</p>
                                </div>
                            @endforelse
                        </div>
                        <small style="color: #6b7280; font-size: 13px; margin-top: 0.5rem; display: block;">
                            Las obras marcadas en verde ya están asignadas
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn-secondary">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        ✓ Asignar Obras Seleccionadas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('asignarObraModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('asignarObraModal').classList.remove('show');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('asignarObraModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-app-layout>
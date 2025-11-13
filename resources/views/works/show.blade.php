<x-app-layout>
    <style>
        /* Layout horizontal tipo grid para el editor */
#edit-persona-wrapper .edit-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}

/* Por si el contenedor padre pone el texto blanco */
#edit-persona-wrapper,
#edit-persona-wrapper label,
#edit-persona-wrapper input {
    color: #111827 !important; /* gris muy oscuro */
}

#edit-persona-wrapper input.form-input {
    background-color: #ffffff;
    border: 1px solid #d1d5db;
}

/* Que no quede pegado a la izquierda en pantallas pequeñas */
@media (max-width: 768px) {
    #edit-persona-wrapper .edit-grid {
        grid-template-columns: 1fr;
    }
}

        .table td,
        .table th {
            color: #020101ff !important;
        }
        /* Estilos SOLO para la tabla del directorio */
#tabla-personas {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 6px; /* separa filas */
    font-size: 15px;
}

#tabla-personas thead th {
    background: #f1f5f9; /* gris clarito */
    color: #1f2937;      /* gris oscuro */
    font-weight: 600;
    padding: 12px 16px;
    border-bottom: 2px solid #e2e8f0;
}

#tabla-personas tbody tr {
    background: #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

#tabla-personas tbody td {
    padding: 12px 16px;
    color: #1e293b; /* negro suave */
}

/* Hover */
#tabla-personas tbody tr:hover {
    background: #f8fafc;
}

/* Botón de eliminar */
#tabla-personas .btn-delete-persona {
    font-size: 24px;
    border: none;
    background: transparent;
    cursor: pointer;
    color: #ef4444; /* rojo suave */
    transition: 0.2s;
}

#tabla-personas .btn-delete-persona:hover {
    transform: scale(1.2);
    color: #dc2626;
}

        
        .obra-show-container {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Header de la Obra */
        .obra-header {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .obra-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .obra-header .code {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .obra-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .meta-icon {
            font-size: 24px;
        }

        .meta-info {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 12px;
            opacity: 0.8;
        }

        .meta-value {
            font-size: 16px;
            font-weight: 600;
        }

        /* Progress Bar */
        .progress-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .progress-label {
            font-size: 14px;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
        }

        .progress-bar-bg {
            background: rgba(0, 0, 0, 0.2);
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar-fill {
            background: #FCC200;
            height: 100%;
            transition: width 0.3s ease;
        }

        /* Action Buttons */
        .header-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
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

        /* Tabs */
        .tabs-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .tabs-header {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            overflow-x: auto;
        }

        .tab-button {
            padding: 1.25rem 2rem;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            color: #6b7280;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tab-button:hover {
            background: #f9fafb;
            color: #2c4a6b;
        }

        .tab-button.active {
            color: #2c4a6b;
            border-bottom-color: #FCC200;
        }

        .tab-content {
            display: none;
            padding: 2rem;
        }

        .tab-content.active {
            display: block;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .info-card-title {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .info-card-value {
            font-size: 16px;
            color: #2c4a6b;
            font-weight: 600;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #FCC200;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #FCC200;
        }

        .timeline-date {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .timeline-title {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .timeline-content {
            font-size: 14px;
            color: #374151;
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

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #FCC200;
        }

        /* List Items */
        .list-item {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .list-item:hover {
            border-color: #FCC200;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .list-item-content {
            flex: 1;
        }

        .list-item-title {
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 0.25rem;
        }

        .list-item-meta {
            font-size: 13px;
            color: #6b7280;
        }

        .list-item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            padding: 0.5rem;
            border-radius: 8px;
            background: white;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: #f9fafb;
            border-color: #2c4a6b;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c4a6b;
        }
    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="obra-show-container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Mensajes --}}
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 border border-red-400 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Header de la Obra --}}
                <div class="obra-header">
                    <h1>{{ $obra->name }}</h1>
                    <div class="code">Código: {{ $obra->code }}</div>
                    
                    <div class="obra-meta">
                        <div class="meta-item">
                            <div class="meta-icon">🏢</div>
                            <div class="meta-info">
                                <span class="meta-label">Cliente</span>
                                <span class="meta-value">{{ $obra->cliente->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">👤</div>
                            <div class="meta-info">
                                <span class="meta-label">Responsable</span>
                                <span class="meta-value">{{ $obra->manager->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">📅</div>
                            <div class="meta-info">
                                <span class="meta-label">Inicio</span>
                                <span class="meta-value">{{ $obra->start_date ? $obra->start_date->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">🎯</div>
                            <div class="meta-info">
                                <span class="meta-label">Estado</span>
                                <span class="meta-value">
                                    @php
                                        $badgeClass = [
                                            'planning' => 'badge-planning',
                                            'in_progress' => 'badge-in_progress',
                                            'paused' => 'badge-paused',
                                            'completed' => 'badge-completed',
                                            'cancelled' => 'badge-cancelled',
                                        ][$obra->status] ?? 'badge-planning';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $obra->status_formatted }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Progreso de la Obra</span>
                            <span>{{ $obra->progress_pct }}%</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ $obra->progress_pct }}%"></div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="header-actions">
                        <a href="{{ route('works.edit', $obra) }}" class="btn btn-primary">
                            ✏️ Editar Obra
                        </a>
                        <a href="{{ route('clientes.show', $obra->cliente) }}" class="btn btn-secondary">
                            👁️ Ver Cliente
                        </a>
                        <a href="{{ route('works.index') }}" class="btn btn-secondary">
                            ← Volver a Obras
                        </a>
                    </div>
                </div>

                {{-- Tabs Container --}}
                <div class="tabs-container">
                    <div class="tabs-header">
                        <button class="tab-button active" onclick="switchTab(event, 'info')">📋 Información</button>
                        <button class="tab-button" onclick="switchTab(event, 'detalles')">📝 Detalles/Historial</button>
                        <button class="tab-button" onclick="switchTab(event, 'camaras')">📹 Cámaras</button>
                        <button class="tab-button" onclick="switchTab(event, 'planos')">📐 Planos</button>
                        <button class="tab-button" onclick="switchTab(event, 'contratos')">📄 Contratos</button>
                        <button class="tab-button" onclick="switchTab(event, 'informes')">📊 Informes</button>
                        <button class="tab-button" onclick="switchTab(event, 'fotos')">📷 Fotos</button>
                        <button class="tab-button" onclick="switchTab(event, 'directorio')">📋 Directorio</button>
                    </div>

                    {{-- Tab: Información General --}}
                    <div id="tab-info" class="tab-content active">
                        <div class="section-header">
                            <h2 class="section-title">Información General</h2>
                        </div>

                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-card-title">Descripción</div>
                                <div class="info-card-value">{{ $obra->description ?? 'Sin descripción' }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-card-title">Dirección</div>
                                <div class="info-card-value">{{ $obra->address ?? 'No especificada' }}</div>
                            </div>

                            @if($obra->lat && $obra->lng)
                                <div class="info-card">
                                    <div class="info-card-title">Coordenadas GPS</div>
                                    <div class="info-card-value">{{ $obra->lat }}, {{ $obra->lng }}</div>
                                </div>
                            @endif

                            @if($obra->budget_amount)
                                <div class="info-card">
                                    <div class="info-card-title">Presupuesto</div>
                                    <div class="info-card-value">{{ $obra->currency ?? 'MXN' }} ${{ number_format($obra->budget_amount, 2) }}</div>
                                </div>
                            @endif

                            @if($obra->end_date)
                                <div class="info-card">
                                    <div class="info-card-title">Fecha de Fin</div>
                                    <div class="info-card-value">{{ $obra->end_date->format('d/m/Y') }}</div>
                                </div>
                            @endif

                            @if($obra->days_remaining !== null)
                                <div class="info-card">
                                    <div class="info-card-title">Días Restantes</div>
                                    <div class="info-card-value">
                                        @if($obra->days_remaining > 0)
                                            {{ $obra->days_remaining }} días
                                        @else
                                            <span style="color: #ef4444;">Fecha límite vencida</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tab: Detalles/Historial --}}
                    <div id="tab-detalles" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">Historial de Detalles</h2>
                            <button class="btn btn-primary" onclick="toggleForm('add-detalle-form')">
                                ➕ Agregar Detalle
                            </button>
                        </div>

                        {{-- Formulario para agregar detalle --}}
                        <div id="add-detalle-form" style="display: none; margin-bottom: 2rem;">
                            <form action="{{ route('obras.detalles.store', $obra) }}" method="POST">
                                @csrf
                                <div class="info-card">
                                    <div class="form-group">
                                        <label class="form-label">Tipo de Detalle</label>
                                        <select name="type" class="form-select" required>
                                            <option value="note">Nota</option>
                                            <option value="progress">Avance</option>
                                            <option value="issue">Incidencia</option>
                                            <option value="delivery">Entrega</option>
                                            <option value="inspection">Inspección</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Título</label>
                                        <input type="text" name="title" class="form-input" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="body" rows="3" class="form-textarea" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Progreso (%)</label>
                                        <input type="number" name="progress_pct" class="form-input" min="0" max="100" value="0">
                                    </div>

                                    <div style="display: flex; gap: 1rem;">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" onclick="toggleForm('add-detalle-form')">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Timeline de detalles --}}
                        @if($obra->detalles->count() > 0)
                            <div class="timeline">
                                @foreach($obra->detalles->sortByDesc('created_at') as $detalle)
                                    <div class="timeline-item">
                                        <div class="timeline-date">{{ $detalle->created_at->format('d/m/Y H:i') }}</div>
                                        <div class="timeline-title">
                                            {{ $detalle->title }}
                                            <span class="badge badge-planning">{{ ucfirst($detalle->type) }}</span>
                                        </div>
                                        <div class="timeline-content">{{ $detalle->body }}</div>
                                        @if($detalle->progress_pct)
                                            <div class="timeline-content" style="margin-top: 0.5rem;">
                                                <strong>Progreso:</strong> {{ $detalle->progress_pct }}%
                                            </div>
                                        @endif
                                        @if($detalle->creador)
                                            <div class="timeline-content" style="margin-top: 0.25rem; font-size: 12px; color: #9ca3af;">
                                                Por: {{ $detalle->creador->name }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">📝</div>
                                <h3>No hay detalles registrados</h3>
                                <p>Comienza agregando el primer detalle de la obra</p>
                            </div>
                        @endif
                    </div>

                    {{-- Tab: Cámaras --}}
                    <div id="tab-camaras" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">Cámaras de Obra</h2>
                            <button class="btn btn-primary" onclick="toggleForm('add-camara-form')">
                                ➕ Agregar Cámara
                            </button>
                        </div>

                        {{-- Formulario agregar cámara --}}
                        <div id="add-camara-form" style="display: none; margin-bottom: 2rem;">
                            <form action="{{ route('obras.camaras.store', $obra) }}" method="POST">
                                @csrf
                                <div class="info-card">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                        <div class="form-group">
                                            <label class="form-label">Nombre de la Cámara</label>
                                            <input type="text" name="name" class="form-input" placeholder="Ej: Cámara Entrada" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">URL de Acceso</label>
                                            <input type="url" name="url" class="form-input" placeholder="https://..." required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Usuario (opcional)</label>
                                            <input type="text" name="username" class="form-input">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Contraseña (opcional)</label>
                                            <input type="password" name="password" class="form-input">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Notas</label>
                                        <textarea name="notes" rows="2" class="form-textarea"></textarea>
                                    </div>

                                    <div style="display: flex; gap: 1rem;">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" onclick="toggleForm('add-camara-form')">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Lista de cámaras --}}
                        @if($obra->camaras->count() > 0)
                            @foreach($obra->camaras as $camara)
                                <div class="list-item">
                                    <div class="list-item-content">
                                        <div class="list-item-title">{{ $camara->name }}</div>
                                        <div class="list-item-meta">
                                            <a href="{{ $camara->url }}" target="_blank" style="color: #2c4a6b;">{{ $camara->url }}</a>
                                        </div>
                                        @if($camara->notes)
                                            <div class="list-item-meta" style="margin-top: 0.25rem;">{{ $camara->notes }}</div>
                                        @endif
                                    </div>
                                    <div class="list-item-actions">
                                        <a href="{{ $camara->url }}" target="_blank" class="btn-icon" title="Ver cámara">
                                            👁️
                                        </a>
                                        <form action="{{ route('obras.camaras.destroy', [$obra, $camara]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon" onclick="return confirm('¿Eliminar esta cámara?')" title="Eliminar">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">📹</div>
                                <h3>No hay cámaras registradas</h3>
                                <p>Agrega los enlaces de acceso remoto a las cámaras de la obra</p>
                            </div>
                        @endif
                    </div>

                    {{-- Tab: Planos --}}
    
{{-- <div id="tab-planos" class="tab-content">
    <div class="section-header">
        <h2 class="section-title">Planos de la Obra</h2>
        <button class="btn btn-primary" onclick="toggleForm('add-plano-form')">
            ➕ Agregar Plano
        </button>
    </div> --}}

    {{-- Formulario agregar plano --}}
    {{-- <div id="add-plano-form" style="display: none; margin-bottom: 2rem;">
        <form action="{{ route('obras.planos.store', $obra) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="info-card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Archivo</label>
                        <input type="file" name="archivo" class="form-input" required accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png">
                        <small style="color: #6b7280; font-size: 12px;">PDF, DWG, DXF, JPG, PNG (Máx. 50MB)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-textarea"></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('add-plano-form')">Cancelar</button>
                </div>
            </div>
        </form>
    </div> --}}
    {{-- Tab: Planos --}}
<div id="tab-planos" class="tab-content">
    <div class="section-header">
        <h2 class="section-title">Planos de la Obra</h2>
        <button class="btn btn-primary" onclick="toggleForm('add-plano-form')">
            ➕ Agregar Plano
        </button>
    </div>

    {{-- Formulario agregar plano --}}
    <div id="add-plano-form" style="display: none; margin-bottom: 2rem;">
        <form id="form-plano" enctype="multipart/form-data">
            @csrf
            <div class="info-card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Archivo</label>
                        <input type="file" name="archivo" class="form-input" required accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png">
                        <small style="color: #6b7280; font-size: 12px;">PDF, DWG, DXF, JPG, PNG (Máx. 50MB)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-textarea"></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Guardar</span>
                        <span class="btn-spinner" style="display: none;">⏳ Subiendo...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('add-plano-form')">Cancelar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Lista de planos --}}
    <div id="planos-list">
        @if($obra->planos->count() > 0)
            @foreach($obra->planos as $plano)
                <div class="list-item" id="plano-{{ $plano->id }}">
                    <div class="list-item-content">
                        <div class="list-item-title">📄 {{ $plano->nombre_archivo }}</div>
                        <div class="list-item-meta">
                            {{ number_format($plano->tamanio / 1024, 2) }} KB • 
                            Subido por {{ $plano->uploadedBy->name }} • 
                            {{ $plano->created_at->format('d/m/Y H:i') }}
                        </div>
                        @if($plano->descripcion)
                            <div class="list-item-meta" style="margin-top: 0.25rem;">{{ $plano->descripcion }}</div>
                        @endif
                    </div>
                    <div class="list-item-actions">
                        <a href="{{ route('obras.planos.download', [$obra, $plano]) }}" class="btn-icon" title="Descargar">
                            💾
                        </a>
                        <button type="button" class="btn-icon" onclick="deletePlano({{ $plano->id }})" title="Eliminar">
                            🗑️
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state" id="planos-empty">
                <div class="empty-icon">📐</div>
                <h3>No hay planos registrados</h3>
                <p>Sube los planos y documentación técnica de la obra</p>
            </div>
        @endif
    </div>
</div>

<script>
// AJAX para Planos
$(document).ready(function() {
    $('#form-plano').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var $btn = $(this).find('button[type="submit"]');
        var $btnText = $btn.find('.btn-text');
        var $btnSpinner = $btn.find('.btn-spinner');
        
        // Deshabilitar botón y mostrar spinner
        $btn.prop('disabled', true);
        $btnText.hide();
        $btnSpinner.show();
        
        $.ajax({
            url: '{{ route("obras.planos.store", $obra) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    // Mostrar notificación
                    showNotification('success', response.message);
                    
                    // Ocultar empty state si existe
                    $('#planos-empty').remove();
                    
                    // Agregar nuevo plano a la lista
                    var planoHtml = `
                        <div class="list-item" id="plano-${response.plano.id}">
                            <div class="list-item-content">
                                <div class="list-item-title">📄 ${response.plano.nombre_archivo}</div>
                                <div class="list-item-meta">
                                    ${(response.plano.tamanio / 1024).toFixed(2)} KB • 
                                    Subido por ${response.plano.uploaded_by.name} • 
                                    ${new Date(response.plano.created_at).toLocaleDateString('es-MX')}
                                </div>
                                ${response.plano.descripcion ? `<div class="list-item-meta" style="margin-top: 0.25rem;">${response.plano.descripcion}</div>` : ''}
                            </div>
                            <div class="list-item-actions">
                                <a href="/obras/${response.plano.obra_id}/planos/${response.plano.id}/download" class="btn-icon" title="Descargar">
                                    💾
                                </a>
                                <button type="button" class="btn-icon" onclick="deletePlano(${response.plano.id})" title="Eliminar">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    `;
                    
                    $('#planos-list').prepend(planoHtml);
                    
                    // Reset form y cerrar
                    $('#form-plano')[0].reset();
                    toggleForm('add-plano-form');
                }
            },
            error: function(xhr) {
                var errorMsg = 'Error al subir el plano';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification('error', errorMsg);
            },
            complete: function() {
                // Rehabilitar botón
                $btn.prop('disabled', false);
                $btnText.show();
                $btnSpinner.hide();
            }
        });
    });
});

function deletePlano(planoId) {
    if(!confirm('¿Eliminar este plano?')) return;
    
    $.ajax({
        url: '/obras/{{ $obra->id }}/planos/' + planoId,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(response.success) {
                showNotification('success', response.message);
                $('#plano-' + planoId).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Si no hay más planos, mostrar empty state
                    if($('#planos-list .list-item').length === 0) {
                        $('#planos-list').html(`
                            <div class="empty-state" id="planos-empty">
                                <div class="empty-icon">📐</div>
                                <h3>No hay planos registrados</h3>
                                <p>Sube los planos y documentación técnica de la obra</p>
                            </div>
                        `);
                    }
                });
            }
        },
        error: function(xhr) {
            var errorMsg = 'Error al eliminar el plano';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showNotification('error', errorMsg);
        }
    });
}

// Sistema de notificaciones
function showNotification(type, message) {
    var bgColor = type === 'success' ? '#10b981' : '#ef4444';
    var icon = type === 'success' ? '✓' : '✕';
    
    var notification = $(`
        <div style="position: fixed; top: 20px; right: 20px; z-index: 10000; background: ${bgColor}; color: white; padding: 1rem 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 0.75rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 20px;">${icon}</span>
            <span>${message}</span>
        </div>
    `);
    
    $('body').append(notification);
    
    setTimeout(function() {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}
</script>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>

    {{-- Lista de planos --}}
    {{-- @if($obra->planos->count() > 0)
        @foreach($obra->planos as $plano)
            <div class="list-item">
                <div class="list-item-content">
                    <div class="list-item-title">📄 {{ $plano->nombre_archivo }}</div>
                    <div class="list-item-meta">
                        {{ number_format($plano->tamanio / 1024, 2) }} KB • 
                        Subido por {{ $plano->uploadedBy->name }} • 
                        {{ $plano->created_at->format('d/m/Y H:i') }}
                    </div>
                    @if($plano->descripcion)
                        <div class="list-item-meta" style="margin-top: 0.25rem;">{{ $plano->descripcion }}</div>
                    @endif
                </div>
                <div class="list-item-actions">
                    <a href="{{ route('obras.planos.download', [$obra, $plano]) }}" class="btn-icon" title="Descargar">
                        💾
                    </a>
                    <form action="{{ route('obras.planos.destroy', [$obra, $plano]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon" onclick="return confirm('¿Eliminar este plano?')" title="Eliminar">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">📐</div>
            <h3>No hay planos registrados</h3>
            <p>Sube los planos y documentación técnica de la obra</p>
        </div>
    @endif
</div> --}}

                    {{-- Tab: Contratos --}}
                 {{-- Tab: Contratos --}}
<div id="tab-contratos" class="tab-content">
    <div class="section-header">
        <h2 class="section-title">Contratos y Documentos</h2>
        <button class="btn btn-primary" onclick="toggleForm('add-contrato-form')">
            ➕ Agregar Contrato
        </button>
    </div>

    {{-- Formulario agregar contrato --}}
    <div id="add-contrato-form" style="display: none; margin-bottom: 2rem;">
        <form action="{{ route('obras.contratos.store', $obra) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="info-card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Archivo</label>
                        <input type="file" name="archivo" class="form-input" required accept=".pdf,.doc,.docx">
                        <small style="color: #6b7280; font-size: 12px;">PDF, DOC, DOCX (Máx. 50MB)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-textarea"></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('add-contrato-form')">Cancelar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Lista de contratos --}}
    @if($obra->contratos->count() > 0)
        @foreach($obra->contratos as $contrato)
            <div class="list-item">
                <div class="list-item-content">
                    <div class="list-item-title">📄 {{ $contrato->nombre_archivo }}</div>
                    <div class="list-item-meta">
                        {{ number_format($contrato->tamanio / 1024, 2) }} KB • 
                        Subido por {{ $contrato->uploadedBy->name }} • 
                        {{ $contrato->created_at->format('d/m/Y H:i') }}
                    </div>
                    @if($contrato->descripcion)
                        <div class="list-item-meta" style="margin-top: 0.25rem;">{{ $contrato->descripcion }}</div>
                    @endif
                </div>
                <div class="list-item-actions">
                    <a href="{{ route('obras.contratos.download', [$obra, $contrato]) }}" class="btn-icon" title="Descargar">
                        💾
                    </a>
                    <form action="{{ route('obras.contratos.destroy', [$obra, $contrato]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon" onclick="return confirm('¿Eliminar este contrato?')" title="Eliminar">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <h3>No hay contratos registrados</h3>
            <p>Sube los contratos y documentos legales de la obra</p>
        </div>
    @endif
</div>

                    {{-- Tab: Informes --}}
                    <div id="tab-informes" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">Informes Semanales</h2>
                        </div>
                        <div class="empty-state">
                            <div class="empty-icon">📊</div>
                            <h3>Sección en desarrollo</h3>
                            <p>Funcionalidad de informes próximamente</p>
                        </div>
                    </div>

                    {{-- Tab: Fotos --}}
<div id="tab-fotos" class="tab-content">
    <div class="section-header">
        <h2 class="section-title">Fotos de la Obra</h2>
        <button class="btn btn-primary" onclick="toggleForm('add-foto-form')">
            ➕ Agregar Fotos
        </button>
    </div>

    {{-- Formulario agregar fotos --}}
    <div id="add-foto-form" style="display: none; margin-bottom: 2rem;">
        <form id="form-foto" enctype="multipart/form-data">
            @csrf
            <div class="info-card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Fotos (Puedes seleccionar varias)</label>
                        <input type="file" name="fotos[]" id="fotos-input" class="form-input" required accept="image/*" multiple>
                        <small style="color: #6b7280; font-size: 12px;">JPG, JPEG, PNG, GIF (Máx. 10MB por foto)</small>
                        <div id="preview-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 0.5rem; margin-top: 1rem;"></div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label class="form-label">Fecha de Captura</label>
                            <input type="date" name="fecha_captura" class="form-input" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción (aplicará a todas)</label>
                            <textarea name="descripcion" rows="3" class="form-textarea" placeholder="Ej: Avance de obra semana 1"></textarea>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; align-items: center;">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Subir Fotos</span>
                        <span class="btn-spinner" style="display: none;">⏳ Subiendo...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('add-foto-form')">Cancelar</button>
                    <span id="file-count" style="color: #6b7280; font-size: 14px;"></span>
                </div>
            </div>
        </form>
    </div>

    {{-- Galería de fotos --}}
    <div id="fotos-gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
        @if($obra->fotos->count() > 0)
            @foreach($obra->fotos as $foto)
                <div class="foto-card" id="foto-{{ $foto->id }}" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div style="position: relative; padding-top: 75%; overflow: hidden; background: #f3f4f6;">
                        <img src="{{ asset('storage/' . $foto->ruta_archivo) }}" 
                             alt="{{ $foto->nombre_archivo }}"
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                             onclick="openImageModal('{{ asset('storage/' . $foto->ruta_archivo) }}', '{{ $foto->nombre_archivo }}')">
                    </div>
                    <div style="padding: 1rem;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 0.5rem;">
                            {{ $foto->fecha_captura ? $foto->fecha_captura->format('d/m/Y') : $foto->created_at->format('d/m/Y') }}
                        </div>
                        @if($foto->descripcion)
                            <div style="font-size: 13px; color: #374151; margin-bottom: 0.5rem;">{{ $foto->descripcion }}</div>
                        @endif
                        <div style="font-size: 11px; color: #9ca3af;">
                            Por {{ $foto->uploadedBy->name }}
                        </div>
                        <div style="margin-top: 0.75rem; display: flex; gap: 0.5rem;">
                            <a href="{{ asset('storage/' . $foto->ruta_archivo) }}" download="{{ $foto->nombre_archivo }}" class="btn-icon" title="Descargar" style="flex: 1; text-align: center; padding: 0.5rem; background: #f3f4f6; border-radius: 6px; text-decoration: none;">
                                💾
                            </a>
                            <button type="button" onclick="deleteFoto({{ $foto->id }})" class="btn-icon" title="Eliminar" style="flex: 1; padding: 0.5rem; background: #fee2e2; border: none; border-radius: 6px; cursor: pointer;">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state" id="fotos-empty" style="grid-column: 1 / -1;">
                <div class="empty-icon">📸</div>
                <h3>No hay fotos registradas</h3>
                <p>Sube fotos del progreso y avances de la obra</p>
            </div>
        @endif
    </div>
</div>

{{-- Modal para ver imagen en grande --}}
<div id="imageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); padding: 2rem;">
    <span onclick="closeImageModal()" style="position: absolute; top: 1rem; right: 2rem; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; object-fit: contain;">
    <div id="modalCaption" style="text-align: center; color: white; padding: 1rem; font-size: 16px;"></div>
</div>
<div id="tab-directorio" class="tab-content">
    <div class="section-header">
        <h2 class="section-title">Directorio de la Obra</h2>
        <button class="btn btn-primary" onclick="toggleForm('add-persona-form')">
            ➕ Agregar Persona
        </button>
    </div>

    {{-- Formulario agregar persona --}}
    <div id="add-persona-form" style="display: none; margin-bottom: 2rem;">
        <form id="form-persona" data-obra-id="{{ $obra->id }}">
            @csrf
            <div class="info-card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="nombre_completo" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Rol en la empresa</label>
                        <input type="text" name="rol_empresa" class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Celular</label>
                        <input type="text" name="celular" class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha de asignación</label>
                        <input type="date" name="fecha_asignacion" class="form-input"
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; align-items: center; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Guardar</span>
                        <span class="btn-spinner" style="display: none;">⏳ Guardando...</span>
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('add-persona-form')">Cancelar</button>
                    <span id="persona-form-msg" style="color: #6b7280; font-size: 14px;"></span>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabla listado de personas --}}
    <table class="table" id="tabla-personas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Fecha asignación</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($obra->personas as $persona)
                <tr data-id="{{ $persona->id }}" class="text-dark">
                    <td>{{ $persona->nombre_completo }}</td>
                    <td>{{ $persona->rol_empresa }}</td>
                    <td>{{ $persona->celular }}</td>
                    <td>{{ $persona->email }}</td>
                    <td>{{ optional($persona->fecha_asignacion)->format('Y-m-d') }}</td>
                    <td>
                        
                        <button
                            class="btn btn-outline-secondary btn-sm btn-edit-persona"
                            data-id="{{ $persona->id }}"
                            data-nombre="{{ $persona->nombre_completo }}"
                            data-rol="{{ $persona->rol_empresa }}"
                            data-celular="{{ $persona->celular }}"
                            data-email="{{ $persona->email }}"
                            data-fecha="{{ optional($persona->fecha_asignacion)->format('Y-m-d') }}"
                            data-url="{{ route('obras.personas.update', [$obra, $persona]) }}"
                        >
                            ✏️
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete-persona"
                                data-url="{{ route('obras.personas.destroy', [$obra, $persona]) }}">
                            🗑
                        </button>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
    {{-- Panel para editar persona (oculto al inicio) --}}
<div id="edit-persona-wrapper" style="display: none; margin-top: 1.5rem;">
    <div class="info-card">
        <h5 style="margin-bottom: 1rem;">Editar persona</h5>

        <form id="form-editar-persona">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-url">

            <div class="edit-grid">
                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre_completo" id="edit-nombre" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Rol en la empresa</label>
                    <input type="text" name="rol_empresa" id="edit-rol" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Celular</label>
                    <input type="text" name="celular" id="edit-celular" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="edit-email" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha de asignación</label>
                    <input type="date" name="fecha_asignacion" id="edit-fecha" class="form-input">
                </div>
                
            </div>

            <div style="margin-top: 1rem; display:flex; gap:0.75rem;">
                <button type="button" class="btn btn-danger" id="btn-cancelar-edicion">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btn-guardar-cambios">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

    
</div>

<script>
    
//editar una persona
$(document).ready(function () {
    // ... (tu código de crear y eliminar personas sigue igual)

    // CLICK EN BOTÓN EDITAR → abre panel y carga datos
    $('#tabla-personas').on('click', '.btn-edit-persona', function () {
        const $btn = $(this);

        // Llenar los campos con los data-*
        $('#edit-nombre').val($btn.data('nombre'));
        $('#edit-rol').val($btn.data('rol'));
        $('#edit-celular').val($btn.data('celular'));
        $('#edit-email').val($btn.data('email'));
        $('#edit-fecha').val($btn.data('fecha') || '');

        // Guardar URL y ID de la persona en el form
        $('#edit-url').val($btn.data('url'));
        $('#form-editar-persona').data('persona-id', $btn.data('id'));

        // Mostrar el panel de edición
        $('#edit-persona-wrapper').slideDown();

        // Hacer scroll suave hacia el editor
        $('html, body').animate({
            scrollTop: $('#edit-persona-wrapper').offset().top - 100
        }, 300);
    });

    // CLICK EN "Cancelar" → ocultar panel
    $('#btn-cancelar-edicion').on('click', function () {
        $('#edit-persona-wrapper').slideUp();
    });

    // CLICK EN "Guardar cambios" → Ajax PUT
    $('#btn-guardar-cambios').on('click', function () {
        const $form = $('#form-editar-persona');
        const url = $('#edit-url').val();
        const personaId = $form.data('persona-id');

        $.ajax({
            url: url,
            method: 'POST', // usamos POST + _method=PUT
            data: $form.serialize(),
            success: function (response) {
                if (response.success) {
                    const p = response.persona;

                    // Actualizar la fila en la tabla
                    const $row = $('#tabla-personas tbody tr[data-id="' + personaId + '"]');
                    $row.find('td').eq(0).text(p.nombre_completo ?? '');
                    $row.find('td').eq(1).text(p.rol_empresa ?? '');
                    $row.find('td').eq(2).text(p.celular ?? '');
                    $row.find('td').eq(3).text(p.email ?? '');
                    $row.find('td').eq(4).text(p.fecha_asignacion ?? '');

                    // Ocultar panel de edición
                    $('#edit-persona-wrapper').slideUp();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    alert('Hay errores de validación, revisa los datos.');
                } else {
                    alert('Ocurrió un error al actualizar.');
                }
            }
        });
    });
});

    //AJAX para Directorio de Personas
$(document).ready(function () {
    // Envío del formulario por Ajax
    $('#form-persona').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const obraId = $form.data('obra-id');
        const url = "{{ route('obras.personas.store', ['obra' => 'OBRA_ID_PLACEHOLDER']) }}"
            .replace('OBRA_ID_PLACEHOLDER', obraId);

        const $btnText = $form.find('.btn-text');
        const $btnSpinner = $form.find('.btn-spinner');
        const $msg = $('#persona-form-msg');
        const fecha = p.fecha_asignacion ? p.fecha_asignacion.split('T')[0] : '';
        $row.find('td').eq(4).text(fecha);


        $btnText.hide();
        $btnSpinner.show();
        $msg.text('');

        $.ajax({
            url: url,
            method: 'POST',
            data: $form.serialize(),
            success: function (response) {
                if (response.success) {
                    const p = response.persona;

                    // Agregar la nueva fila a la tabla
                    const rowHtml = `
                        <tr data-id="${p.id}" class="text-dark text-center">
                            <td>${p.nombre_completo ?? ''}</td>
                            <td>${p.rol_empresa ?? ''}</td>
                            <td>${p.celular ?? ''}</td>
                            <td>${p.email ?? ''}</td>
                            <td>${p.fecha_asignacion ? p.fecha_asignacion.split('T')[0] : ''}</td>

                            <td>
                                <button class="btn btn-danger btn-sm btn-delete-persona"
                                        data-url="/obras/${obraId}/personas/${p.id}">
                                    🗑
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete-persona"
                                        data-url="/obras/${obraId}/personas/${p.id}">
                                    🗑 
                                    </button>
                                
                            </td>
                            
                        </tr>
                    `;


                    $('#tabla-personas tbody').append(rowHtml);
                    $form[0].reset();
                    $msg.text(response.message).css('color', 'green');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // errores de validación
                    const errors = xhr.responseJSON.errors;
                    let text = 'Errores: ';
                    for (const field in errors) {
                        text += errors[field].join(', ') + ' ';
                    }
                    $msg.text(text).css('color', 'red');
                } else {
                    $msg.text('Ocurrió un error al guardar.').css('color', 'red');
                }
            },
            complete: function () {
                $btnText.show();
                $btnSpinner.hide();
            }
        });
    });

    // Eliminar persona por Ajax (delegado para filas nuevas)
    $('#tabla-personas').on('click', '.btn-delete-persona', function () {
        if (!confirm('¿Eliminar esta persona del directorio?')) return;

        const $btn = $(this);
        const url = $btn.data('url');
        const $row = $btn.closest('tr');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    $row.remove();
                }
            },
            error: function () {
                alert('No se pudo eliminar la persona.');
            }
        });
    });
});
</script>


<script>
// AJAX para Fotos
$(document).ready(function() {
    // Preview de fotos seleccionadas
    $('#fotos-input').on('change', function(e) {
        const files = e.target.files;
        const previewContainer = $('#preview-container');
        const fileCount = $('#file-count');
        
        previewContainer.html('');
        fileCount.text(files.length > 0 ? `${files.length} foto(s) seleccionada(s)` : '');
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img>').attr('src', e.target.result).css({
                        'width': '100%',
                        'height': '100px',
                        'object-fit': 'cover',
                        'border-radius': '8px',
                        'border': '2px solid #e5e7eb'
                    });
                    previewContainer.append(img);
                }
                reader.readAsDataURL(file);
            }
        });
    });

    // Submit fotos
    $('#form-foto').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var $btn = $(this).find('button[type="submit"]');
        var $btnText = $btn.find('.btn-text');
        var $btnSpinner = $btn.find('.btn-spinner');
        
        // Deshabilitar botón y mostrar spinner
        $btn.prop('disabled', true);
        $btnText.hide();
        $btnSpinner.show();
        
        $.ajax({
            url: '{{ route("obras.fotos.store", $obra) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    showNotification('success', response.message);
                    
                    // Ocultar empty state si existe
                    $('#fotos-empty').remove();
                    
                    // Agregar nuevas fotos a la galería
                    response.fotos.forEach(function(foto) {
                        var fotoHtml = `
                            <div class="foto-card" id="foto-${foto.id}" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                                <div style="position: relative; padding-top: 75%; overflow: hidden; background: #f3f4f6;">
                                    <img src="/storage/${foto.ruta_archivo}" 
                                         alt="${foto.nombre_archivo}"
                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                                         onclick="openImageModal('/storage/${foto.ruta_archivo}', '${foto.nombre_archivo}')">
                                </div>
                                <div style="padding: 1rem;">
                                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 0.5rem;">
                                        ${new Date(foto.fecha_captura || foto.created_at).toLocaleDateString('es-MX')}
                                    </div>
                                    ${foto.descripcion ? `<div style="font-size: 13px; color: #374151; margin-bottom: 0.5rem;">${foto.descripcion}</div>` : ''}
                                    <div style="font-size: 11px; color: #9ca3af;">
                                        Por ${foto.uploaded_by.name}
                                    </div>
                                    <div style="margin-top: 0.75rem; display: flex; gap: 0.5rem;">
                                        <a href="/storage/${foto.ruta_archivo}" download="${foto.nombre_archivo}" class="btn-icon" title="Descargar" style="flex: 1; text-align: center; padding: 0.5rem; background: #f3f4f6; border-radius: 6px; text-decoration: none;">
                                            💾
                                        </a>
                                        <button type="button" onclick="deleteFoto(${foto.id})" class="btn-icon" title="Eliminar" style="flex: 1; padding: 0.5rem; background: #fee2e2; border: none; border-radius: 6px; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#fotos-gallery').prepend(fotoHtml);
                    });
                    
                    // Reset form y cerrar
                    $('#form-foto')[0].reset();
                    $('#preview-container').html('');
                    $('#file-count').text('');
                    toggleForm('add-foto-form');
                }
            },
            error: function(xhr) {
                var errorMsg = 'Error al subir las fotos';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification('error', errorMsg);
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btnText.show();
                $btnSpinner.hide();
            }
        });
    });
});

function deleteFoto(fotoId) {
    if(!confirm('¿Eliminar esta foto?')) return;
    
    $.ajax({
        url: '/obras/{{ $obra->id }}/fotos/' + fotoId,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(response.success) {
                showNotification('success', response.message);
                $('#foto-' + fotoId).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Si no hay más fotos, mostrar empty state
                    if($('#fotos-gallery .foto-card').length === 0) {
                        $('#fotos-gallery').html(`
                            <div class="empty-state" id="fotos-empty" style="grid-column: 1 / -1;">
                                <div class="empty-icon">📸</div>
                                <h3>No hay fotos registradas</h3>
                                <p>Sube fotos del progreso y avances de la obra</p>
                            </div>
                        `);
                    }
                });
            }
        },
        error: function(xhr) {
            var errorMsg = 'Error al eliminar la foto';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showNotification('error', errorMsg);
        }
    });
}

// Modal para ver imágenes
function openImageModal(src, caption) {
    $('#imageModal').show();
    $('#modalImage').attr('src', src);
    $('#modalCaption').text(caption);
}

function closeImageModal() {
    $('#imageModal').hide();
}

// Cerrar modal con ESC
$(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Hover effect en foto cards
$(document).on('mouseenter', '.foto-card', function() {
    $(this).css({
        'transform': 'translateY(-4px)',
        'box-shadow': '0 8px 16px rgba(0,0,0,0.15)'
    });
}).on('mouseleave', '.foto-card', function() {
    $(this).css({
        'transform': 'translateY(0)',
        'box-shadow': '0 2px 8px rgba(0,0,0,0.1)'
    });
});
</script>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(event, tabName) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Mostrar el tab seleccionado
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }

        function toggleForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    
   

</x-app-layout>
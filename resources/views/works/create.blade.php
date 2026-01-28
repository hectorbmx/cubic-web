<x-app-layout>
    <style>
        .obra-form-container {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .client-header {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .client-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .client-header .client-info {
            display: flex;
            gap: 2rem;
            font-size: 14px;
            opacity: 0.9;
        }

        .client-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-header h1 {
            font-size: 28px;
            color: #2c4a6b;
            font-weight: 700;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c4a6b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
            color: #374151;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #FCC200;
            background: white;
        }

        .form-input:disabled, .form-select:disabled {
            background: #e5e7eb;
            cursor: not-allowed;
        }

        .form-input.error, .form-select.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 0.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(252, 194, 0, 0.35);
        }

        .btn-secondary {
            background: white;
            color: #2c4a6b;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .help-text {
            font-size: 13px;
            color: #6b7280;
            margin-top: 0.25rem;
        }
    </style>

    <div class="obra-form-container">
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Header con información del cliente --}}
                @if($cliente)
                    <div class="client-header">
                        <h2>🏢 {{ $cliente->name }}</h2>
                        <div class="client-info">
                            @if($cliente->company)
                                <div class="client-info-item">
                                    <span>🏭</span>
                                    <span>{{ $cliente->company }}</span>
                                </div>
                            @endif
                            @if($cliente->email)
                                <div class="client-info-item">
                                    <span>📧</span>
                                    <span>{{ $cliente->email }}</span>
                                </div>
                            @endif
                            @if($cliente->phone)
                                <div class="client-info-item">
                                    <span>📞</span>
                                    <span>{{ $cliente->phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Formulario --}}
                <div class="form-card">
                    <div class="form-header">
                        <h1>Nueva Obra</h1>
                        <a href="{{ $cliente ? route('clientes.show', $cliente) : route('works.index') }}" class="btn btn-secondary">
                            ← Volver
                        </a>
                    </div>

                    <form action="{{ route('works.store') }}" method="POST">
                        @csrf

                        {{-- Cliente (hidden si viene de URL) --}}
                        @if($cliente)
                            <input type="hidden" name="client_id" value="{{ $cliente->id }}">
                        @endif

                        {{-- Manager (hidden para admin, select para superadmin) --}}
                        @if(auth()->user()->hasRole('admin'))
                            <input type="hidden" name="manager_user_id" value="{{ auth()->id() }}">
                        @endif

                        {{-- Información Básica --}}
                        <div class="form-section">
                            <h3 class="section-title">Información Básica</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Código --}}
                                <div class="form-group">
                                    <label class="form-label">
                                        Código de Obra <span class="required">*</span>
                                    </label>
                                    <input type="text" name="code" value="{{ old('code') }}" 
                                           class="form-input @error('code') error @enderror" required
                                           placeholder="Ej: OB-2025-001">
                                    <p class="help-text">Código único para identificar la obra</p>
                                    @error('code')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nombre --}}
                                <div class="form-group">
                                    <label class="form-label">
                                        Nombre de la Obra <span class="required">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="form-input @error('name') error @enderror" required
                                           placeholder="Ej: Construcción Edificio Corporativo">
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Cliente (si no viene de URL) --}}
                                @if(!$cliente)
                                    <div class="form-group md:col-span-2">
                                        <label class="form-label">
                                            Cliente <span class="required">*</span>
                                        </label>
                                        <select name="client_id" class="form-select @error('client_id') error @enderror" required>
                                            <option value="">Selecciona un cliente</option>
                                            @foreach($clientes as $c)
                                                <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <div class="form-group md:col-span-2">
                                        <label class="form-label">Cliente</label>
                                        <input type="text" value="{{ $cliente->name }}" class="form-input" disabled>
                                    </div>
                                @endif

                                {{-- Manager (solo visible para superadmin) --}}
                                @if(auth()->user()->hasRole('superadmin'))
                                    <div class="form-group md:col-span-2">
                                        <label class="form-label">
                                            Responsable/Manager
                                        </label>
                                        <select name="manager_user_id" class="form-select">
                                            <option value="">Selecciona un responsable (opcional)</option>
                                            @foreach($managers as $manager)
                                                <option value="{{ $manager->id }}" {{ old('manager_user_id') == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="help-text">Usuario encargado de supervisar la obra</p>
                                    </div>
                                @else
                                    <div class="form-group md:col-span-2">
                                        <label class="form-label">Responsable/Manager</label>
                                        <input type="text" value="{{ auth()->user()->name }} (Tú)" class="form-input" disabled>
                                    </div>
                                @endif
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" rows="3" 
                                          class="form-textarea @error('description') error @enderror"
                                          placeholder="Describe brevemente el proyecto...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Estado y Progreso --}}
                        <div class="form-section">
                            <h3 class="section-title">Estado y Progreso</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Estado --}}
                                <div class="form-group">
                                    <label class="form-label">
                                        Estado <span class="required">*</span>
                                    </label>
                                    <select name="status" class="form-select @error('status') error @enderror" required>
                                        <option value="planning" {{ old('status', 'planning') == 'planning' ? 'selected' : '' }}>Planificación</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>Pausada</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    @error('status')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Progreso --}}
                                <div class="form-group">
                                    <label class="form-label">Progreso (%)</label>
                                    <input type="number" name="progress_pct" value="{{ old('progress_pct', 0) }}" 
                                           class="form-input @error('progress_pct') error @enderror"
                                           min="0" max="100">
                                    <p class="help-text">Porcentaje de avance actual (0-100)</p>
                                    @error('progress_pct')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Fechas --}}
                        <div class="form-section">
                            <h3 class="section-title">Fechas del Proyecto</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Fecha Inicio --}}
                                <div class="form-group">
                                    <label class="form-label">Fecha de Inicio</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" 
                                           class="form-input @error('start_date') error @enderror">
                                    @error('start_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Fecha Fin --}}
                                <div class="form-group">
                                    <label class="form-label">Fecha de Fin Estimada</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" 
                                           class="form-input @error('end_date') error @enderror">
                                    @error('end_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Ubicación --}}
                        <div class="form-section">
                            <h3 class="section-title">Ubicación</h3>
                            
                            <div class="form-group">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="address" value="{{ old('address') }}" 
                                       class="form-input @error('address') error @enderror"
                                       placeholder="Calle, número, colonia, ciudad">
                                @error('address')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Latitud --}}
                                <div class="form-group">
                                    <label class="form-label">Latitud</label>
                                    <input type="number" step="any" name="lat" value="{{ old('lat') }}" 
                                           class="form-input @error('lat') error @enderror"
                                           placeholder="20.6597">
                                    <p class="help-text">Coordenada GPS (opcional)</p>
                                    @error('lat')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Longitud --}}
                                <div class="form-group">
                                    <label class="form-label">Longitud</label>
                                    <input type="number" step="any" name="lng" value="{{ old('lng') }}" 
                                           class="form-input @error('lng') error @enderror"
                                           placeholder="-103.3496">
                                    <p class="help-text">Coordenada GPS (opcional)</p>
                                    @error('lng')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Presupuesto --}}
                        <div class="form-section">
                            <h3 class="section-title">Presupuesto</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Monto --}}
                                <div class="form-group">
                                    <label class="form-label">Monto del Presupuesto</label>
                                    <input type="number" step="0.01" name="budget_amount" value="{{ old('budget_amount') }}" 
                                           class="form-input @error('budget_amount') error @enderror"
                                           placeholder="0.00">
                                    @error('budget_amount')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Moneda --}}
                                
                                        <div class="form-group">
                                            <label class="form-label">Moneda</label>

                                            <select name="currency" class="form-select @error('currency') error @enderror">
                                                {{-- Default --}}
                                                <option value="MXN" {{ old('currency', 'MXN') == 'MXN' ? 'selected' : '' }}>
                                                    MXN - Peso Mexicano
                                                </option>

                                                {{-- América --}}
                                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>
                                                    USD - Dólar estadounidense
                                                </option>
                                                <option value="COP" {{ old('currency') == 'COP' ? 'selected' : '' }}>
                                                    COP - Peso colombiano
                                                </option>
                                                <option value="CLP" {{ old('currency') == 'CLP' ? 'selected' : '' }}>
                                                    CLP - Peso chileno
                                                </option>
                                                <option value="DOP" {{ old('currency') == 'DOP' ? 'selected' : '' }}>
                                                    DOP - Peso dominicano
                                                </option>
                                                <option value="UYU" {{ old('currency') == 'UYU' ? 'selected' : '' }}>
                                                    UYU - Peso uruguayo
                                                </option>
                                                <option value="PAB" {{ old('currency') == 'PAB' ? 'selected' : '' }}>
                                                    PAB - Balboa panameño
                                                </option>
                                                <option value="BRL" {{ old('currency') == 'BRL' ? 'selected' : '' }}>
                                                    BRL - Real brasileño
                                                </option>
                                                <option value="PEN" {{ old('currency') == 'PEN' ? 'selected' : '' }}>
                                                    PEN - Sol peruano
                                                </option>

                                                {{-- Europa / África --}}
                                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>
                                                    EUR - Euro
                                                </option>
                                                <option value="MAD" {{ old('currency') == 'MAD' ? 'selected' : '' }}>
                                                    MAD - Dírham marroquí
                                                </option>
                                            </select>

                                            @error('currency')
                                                <p class="error-message">{{ $message }}</p>
    @enderror
</div>

                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="form-actions">
                            <a href="{{ $cliente ? route('clientes.show', $cliente) : route('works.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                ✓ Crear Obra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
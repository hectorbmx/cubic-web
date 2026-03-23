<x-app-layout>
    <style>
        .edit-cliente-page {
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
            gap: 1rem;
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

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 1.5rem;
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
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
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
            background: white !important;
            color: #374151 !important;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #FCC200;
            background: white !important;
        }

        .form-input.error, .form-select.error, .form-textarea.error {
            border-color: #ef4444;
            background: #fef2f2 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .helper-text {
            color: #6b7280;
            font-size: 13px;
            margin-top: 0.25rem;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            transition: all 0.2s ease;
            background: #f9fafb;
            cursor: pointer;
        }

        .checkbox-item:hover {
            border-color: #FCC200;
            background: white;
            transform: translateY(-1px);
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: #FCC200;
        }

        .checkbox-label {
            font-size: 14px;
            color: #374151;
            cursor: pointer;
            flex: 1;
        }

        .checkbox-label .role-badge {
            color: #6b7280;
            font-size: 12px;
            background: #e5e7eb;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            margin-left: 0.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
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

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
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
            border: 2px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 2px solid #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions > div {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="edit-cliente-page">
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Hero Header --}}
                <div class="page-hero">
                    <div class="hero-content">
                        <div>
                            <h1 class="hero-title">✏️ Editar Cliente</h1>
                            <p class="hero-subtitle">Actualiza la información del cliente</p>
                        </div>
                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary" style="background: white;">
                            ← Volver
                        </a>
                    </div>
                </div>

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        <span style="font-size: 20px;">⚠</span>
                        <div>
                            <strong>Hay errores en el formulario:</strong>
                            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Información del Cliente --}}
                    <div class="form-card">
                        <div class="form-section">
                            <h3 class="section-title">
                                <span>📋</span>
                                Información del Cliente
                            </h3>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        Nombre <span class="required">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $cliente->name) }}" 
                                           class="form-input @error('name') error @enderror" required>
                                    @error('name')
                                        <p class="error-message">⚠ {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $cliente->email) }}" 
                                           class="form-input @error('email') error @enderror">
                                    @error('email')
                                        <p class="error-message">⚠ {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="phone" value="{{ old('phone', $cliente->phone) }}" 
                                           class="form-input @error('phone') error @enderror">
                                    @error('phone')
                                        <p class="error-message">⚠ {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Empresa/Compañía</label>
                                    <input type="text" name="company" value="{{ old('company', $cliente->company) }}" 
                                           class="form-input @error('company') error @enderror">
                                    @error('company')
                                        <p class="error-message">⚠ {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Dirección</label>
                                <textarea name="address" rows="3" 
                                          class="form-textarea @error('address') error @enderror">{{ old('address', $cliente->address) }}</textarea>
                                @error('address')
                                    <p class="error-message">⚠ {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Persona de Contacto</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person', $cliente->contact_person) }}" 
                                       class="form-input @error('contact_person') error @enderror">
                                @error('contact_person')
                                    <p class="error-message">⚠ {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Asignación de Usuarios (solo para superadmin) --}}
                    @if(auth()->user()->isSuperAdmin())
                        <div class="form-card">
                            <div class="form-section">
                                <h3 class="section-title">
                                    <span>👥</span>
                                    Usuarios Asignados
                                </h3>
                                <p class="helper-text" style="margin-bottom: 1.5rem;">
                                    Selecciona los usuarios que podrán gestionar este cliente y sus obras
                                </p>
                                
                                @if($usuarios->count() > 0)
                                    <div class="checkbox-grid">
                                        @foreach($usuarios as $usuario)
                                            <div class="checkbox-item">
                                                <input type="checkbox" name="users[]" value="{{ $usuario->id }}" 
                                                       id="user_{{ $usuario->id }}"
                                                       {{ in_array($usuario->id, old('users', $usuariosAsignados)) ? 'checked' : '' }}>
                                                <label for="user_{{ $usuario->id }}" class="checkbox-label">
                                                    <div>
                                                        <strong>{{ $usuario->name }}</strong>
                                                        <span class="role-badge">{{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}</span>
                                                    </div>
                                                    <small style="color: #6b7280; display: block; margin-top: 0.25rem;">
                                                        {{ $usuario->email }}
                                                    </small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">👤</div>
                                        <p>No hay usuarios disponibles para asignar</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Botones de Acción --}}
                    <div class="form-card">
                        <div class="form-actions">
                            <div>
                                @if(auth()->user()->isSuperAdmin())
                                    <button type="button" 
                                            onclick="if(confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')) document.getElementById('delete-form').submit();" 
                                            class="btn btn-danger">
                                        🗑️ Eliminar Cliente
                                    </button>
                                @endif
                            </div>
                            <div style="display: flex; gap: 1rem;">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    ✓ Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Formulario de eliminación oculto --}}
              @if(auth()->user()->isSuperAdmin())
                    <button type="button" onclick="confirmDelete()">Eliminar cliente</button>

                    <form id="delete-form" action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete() {
                            if (confirm('¿Seguro que deseas eliminar este cliente?')) {
                                document.getElementById('delete-form').submit();
                            }
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="c33-page">
        <div class="c33-container">

            {{-- Header card --}}
            {{-- <div class="c33-card c33-card-header"> --}}
            <div class="c33-card c33-card-header c33-card-header-blue">
    
                <div class="c33-header-row">
                    
                    <div>
                        <div class="c33-title-row">
                            <span class="c33-title-icon">✏️</span>
                            <h1 class="c33-title">Editar Obra</h1>
                        </div>
                        <p class="c33-subtitle">{{ $obra->name }}</p>
                    </div>

                    <a href="{{ route('works.show', $obra) }}" class="c33-btn c33-btn-dark">
                        ← Volver a la Obra
                    </a>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('works.update', $obra) }}"  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="c33-card c33-card-body">
{{-- Foto de la obra (principal) --}}
<div class="c33-section">
    <div class="c33-section-head">
        <h3 class="c33-section-title">
            <span class="c33-section-icon">🖼️</span>
            Foto de la obra
        </h3>
        <div class="c33-divider"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
        {{-- Preview actual (si existe) --}}
        <div class="md:col-span-1">
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                @if(!empty($obra->cover_image))
                    <img
                        src="{{ asset('storage/'.$obra->cover_image) }}"
                        alt="Foto de la obra"
                        class="w-full h-44 object-cover"
                    >
                @else
                    <div class="w-full h-44 flex items-center justify-center text-sm text-gray-500">
                        Sin foto
                    </div>
                @endif
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Recomendado: JPG/PNG, máximo 5MB.
            </p>
        </div>

        {{-- Input --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Subir nueva foto
            </label>

           <input
    type="file"
    name="cover_image"
    accept="image/*"
    class="block w-full text-sm
           text-gray-800                 {{-- 👈 ESTE --}}
           file:mr-4 file:py-2 file:px-4
           file:rounded-lg file:border-0
           file:text-sm file:font-semibold
           file:bg-gray-900 file:text-white
           hover:file:bg-gray-800
           border border-gray-300 rounded-lg p-2 bg-white"
/>


            @error('cover_image')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <p class="mt-2 text-sm text-gray-600">
                Si subes una nueva imagen, reemplazará la anterior.
            </p>
        </div>
    </div>
</div>

                    {{-- Información Básica --}}
                    <div class="c33-section">
                        <div class="c33-section-head">
                            <h3 class="c33-section-title">
                                <span class="c33-section-icon">📋</span>
                                Información Básica
                            </h3>
                            <div class="c33-divider"></div>
                        </div>

                        <div class="c33-grid">
                            <div class="c33-field">
                                <label class="c33-label">Código *</label>
                                <input type="text" name="code" class="c33-input" value="{{ old('code', $obra->code) }}" required>
                                @error('code') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Nombre de la Obra *</label>
                                <input type="text" name="name" class="c33-input" value="{{ old('name', $obra->name) }}" required>
                                @error('name') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Cliente *</label>
                                <select name="client_id" class="c33-select" required>
                                    <option value="">Seleccionar cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('client_id', $obra->client_id) == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Responsable *</label>
                                <select name="manager_user_id" class="c33-select" required>
                                    <option value="">Seleccionar responsable</option>
                                    @foreach($managers as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('manager_user_id', $obra->manager_user_id) == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_user_id') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field c33-col-span-2">
                                <label class="c33-label">Descripción</label>
                                <textarea name="description" rows="4" class="c33-textarea">{{ old('description', $obra->description) }}</textarea>
                                @error('description') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Estado y Progreso --}}
                    <div class="c33-section">
                        <div class="c33-section-head">
                            <h3 class="c33-section-title">
                                <span class="c33-section-icon">🎯</span>
                                Estado y Progreso
                            </h3>
                            <div class="c33-divider"></div>
                        </div>

                        <div class="c33-grid">
                            <div class="c33-field">
                                <label class="c33-label">Estado *</label>
                                <select name="status" class="c33-select" required>
                                    <option value="planning"   {{ old('status', $obra->status) == 'planning' ? 'selected' : '' }}>Planeación</option>
                                    <option value="in_progress" {{ old('status', $obra->status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                    <option value="paused"     {{ old('status', $obra->status) == 'paused' ? 'selected' : '' }}>Pausada</option>
                                    <option value="completed"  {{ old('status', $obra->status) == 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled"  {{ old('status', $obra->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                @error('status') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Progreso (%) *</label>
                                <input type="number" name="progress_pct" class="c33-input"
                                       value="{{ old('progress_pct', $obra->progress_pct) }}" min="0" max="100" required>
                                @error('progress_pct') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Fecha de Inicio</label>
                                <input type="date" name="start_date" class="c33-input"
                                       value="{{ old('start_date', $obra->start_date ? $obra->start_date->format('Y-m-d') : '') }}">
                                @error('start_date') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Fecha de Fin</label>
                                <input type="date" name="end_date" class="c33-input"
                                       value="{{ old('end_date', $obra->end_date ? $obra->end_date->format('Y-m-d') : '') }}">
                                @error('end_date') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Ubicación --}}
                    <div class="c33-section">
                        <div class="c33-section-head">
                            <h3 class="c33-section-title">
                                <span class="c33-section-icon">📍</span>
                                Ubicación
                            </h3>
                            <div class="c33-divider"></div>
                        </div>

                        <div class="c33-grid">
                            <div class="c33-field c33-col-span-2">
                                <label class="c33-label">Dirección</label>
                                <input type="text" name="address" class="c33-input" value="{{ old('address', $obra->address) }}">
                                @error('address') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Latitud</label>
                                <input type="number" step="any" name="lat" class="c33-input" value="{{ old('lat', $obra->lat) }}">
                                @error('lat') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Longitud</label>
                                <input type="number" step="any" name="lng" class="c33-input" value="{{ old('lng', $obra->lng) }}">
                                @error('lng') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Presupuesto --}}
                    <div class="c33-section">
                        <div class="c33-section-head">
                            <h3 class="c33-section-title">
                                <span class="c33-section-icon">💰</span>
                                Presupuesto
                            </h3>
                            <div class="c33-divider"></div>
                        </div>

                        <div class="c33-grid">
                            <div class="c33-field">
                                <label class="c33-label">Monto</label>
                                <input type="number" step="0.01" name="budget_amount" class="c33-input"
                                       value="{{ old('budget_amount', $obra->budget_amount) }}">
                                @error('budget_amount') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="c33-field">
                                <label class="c33-label">Moneda</label>
                                <select name="currency" class="c33-select">
                                    <option value="MXN" {{ old('currency', $obra->currency) == 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                    <option value="USD" {{ old('currency', $obra->currency) == 'USD' ? 'selected' : '' }}>USD - Dólar</option>
                                    <option value="EUR" {{ old('currency', $obra->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                </select>
                                @error('currency') <div class="c33-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="c33-actions">
                        <a href="{{ route('works.show', $obra) }}" class="c33-btn c33-btn-ghost">
                            Cancelar
                        </a>
                        <button type="submit" class="c33-btn c33-btn-primary">
                            Guardar Cambios
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <style>
        /* Page layout aligned to your app (light background / centered container) */
        .c33-page { padding: 24px 0; }
        .c33-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        /* Card */
        .c33-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e9eef5;
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.06);
        }
        .c33-card-header { padding: 22px 24px; margin-bottom: 18px; }
        .c33-card-body { padding: 22px 24px; }

        .c33-header-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .c33-title-row { display: flex; align-items: center; gap: 10px; }
        .c33-title-icon { font-size: 20px; }
        .c33-title { margin: 0; font-size: 22px; font-weight: 800; color: #1f2937; }
        .c33-subtitle { margin: 6px 0 0 0; color: #6b7280; font-size: 14px; }

        /* Section */
        .c33-section { margin-bottom: 22px; }
        .c33-section-head { margin-bottom: 14px; }
        .c33-section-title { margin: 0 0 10px 0; font-size: 16px; font-weight: 800; color: #1f2937; display: flex; align-items: center; gap: 10px; }
        .c33-section-icon { font-size: 16px; }
        .c33-divider { height: 2px; background: #f3c316; border-radius: 999px; opacity: 0.9; }

        /* Grid */
        .c33-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .c33-col-span-2 { grid-column: 1 / -1; }

        @media (max-width: 860px) {
            .c33-grid { grid-template-columns: 1fr; }
            .c33-col-span-2 { grid-column: auto; }
        }

        /* Fields */
        .c33-field { display: flex; flex-direction: column; gap: 6px; }
        .c33-label { font-size: 13px; font-weight: 700; color: #374151; }

        .c33-input, .c33-select, .c33-textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #dbe4f0;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .c33-textarea { resize: vertical; min-height: 110px; }

        .c33-input:focus, .c33-select:focus, .c33-textarea:focus {
            outline: none;
            border-color: #f3c316;
            box-shadow: 0 0 0 3px rgba(243, 195, 22, 0.22);
        }

        .c33-error { margin-top: 2px; font-size: 12px; color: #dc2626; }

        /* Buttons (match your app: primary yellow + dark action) */
        .c33-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            border: 1px solid transparent;
            transition: transform .12s ease, box-shadow .12s ease, background-color .12s ease, border-color .12s ease;
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
        }

        .c33-btn-primary {
            background: #f3c316;
            color: #1f2937;
            box-shadow: 0 8px 18px rgba(243, 195, 22, 0.22);
        }
        .c33-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 22px rgba(243, 195, 22, 0.28); }

        .c33-btn-dark {
            background: #1f3552;
            color: #ffffff;
            border-color: rgba(31, 53, 82, 0.25);
        }
        .c33-btn-dark:hover { transform: translateY(-1px); box-shadow: 0 10px 22px rgba(31, 53, 82, 0.18); }

        .c33-btn-ghost {
            background: #ffffff;
            color: #1f3552;
            border-color: #dbe4f0;
        }
        .c33-btn-ghost:hover { transform: translateY(-1px); box-shadow: 0 10px 22px rgba(17, 24, 39, 0.08); }

        /* Footer actions */
        .c33-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #eef2f7;
            margin-top: 10px;
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
    </style>
</x-app-layout>

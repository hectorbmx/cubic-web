<x-app-layout>
    <style>
        /* --- TUS ESTILOS EXISTENTES --- */
        /* (copio los que ya tenías tal cual) */

        /* Select2... */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            min-height: 42px !important;
            padding: 0.5rem 0.75rem !important;
            background-color: white !important;
        }
        .select2-results__option {
            color: #111827 !important;
            background-color: white !important;
            padding: 8px 12px !important;
        }
        .select2-results__option--highlighted {
            background-color: #2c4a6b !important;
            color: white !important;
        }
        .select2-results__option--selected {
            background-color: #e5e7eb !important;
            color: #111827 !important;
        }
        .select2-selection__choice {
            background-color: #2c4a6b !important;
            color: white !important;
            border: none !important;
            border-radius: 0.25rem !important;
            padding: 4px 8px !important;
            margin: 2px !important;
        }
        .select2-selection__choice__remove {
            color: white !important;
            margin-right: 5px !important;
        }
        .select2-selection__choice__remove:hover {
            color: #fca5a5 !important;
        }
        .select2-selection__placeholder { color: #6b7280 !important; }
        .select2-search__field { color: #111827 !important; }
        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
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
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            border: 1px solid #d1d5db;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover { background: #f3f4f6; }

        .btn-danger {
            background-color: #e11d48;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .btn-danger:hover { background-color: #be123c; }

        .btn-outline {
            border-radius: 9999px;
            border: 1px solid #d1d5db;
            padding: 0.25rem 0.75rem;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .btn-outline:hover { background-color: #f3f4f6; }

        .input-search {
            border-radius: 9999px;
            border: 1px solid #d1d5db;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            font-size: 14px;
            width: 100%;
        }
        .input-search:focus {
            outline: none;
            border-color: #2c4a6b;
            box-shadow: 0 0 0 1px #2c4a6b;
        }
        .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .switch { position: relative; display: inline-block; width: 42px; height: 22px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #e5e7eb;
            transition: .3s;
            border-radius: 9999px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px; width: 18px;
            left: 2px; bottom: 2px;
            background-color: white;
            transition: .3s;
            border-radius: 9999px;
        }
        input:checked + .slider { background-color: #2c4a6b; }
        input:checked + .slider:before { transform: translateX(20px); }

        .avatar-circle {
            border-radius: 9999px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.15rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25rem;
            white-space: nowrap;
        }
        .role-superadmin { background:#F3E8FF; color:#6B21A8; }
        .role-admin      { background:#2c4a6b; color:#fff;    }
        .role-user       { background:#E5E7EB; color:#111827; }
        .role-none       { background:#F3F4F6; color:#4B5563; }

        /* --- NUEVO: layout tipo “hero” igual que Clientes/Obras --- */
        .usuarios-page {
            background: #f5f7fa;
            min-height: 100vh;
            font-family: 'Inter','Segoe UI',system-ui,-apple-system,sans-serif;
        }
        .page-hero {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            padding: 1.75rem 2rem;
            border-radius: 16px;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .page-hero-title h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }
        .page-hero-title p {
            font-size: 14px;
            margin-top: 0.25rem;
            opacity: .9;
        }
        .card-filters,
        .card-table {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
        }
        .card-table { padding: 0; }
    </style>

    {{-- Deja vacío el header de Jetstream para que no duplique el título --}}
    <x-slot name="header"></x-slot>

    <div class="usuarios-page">
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- HERO PRINCIPAL --}}
                <div class="page-hero">
                    <div class="page-hero-title">
                        <h1>Gestión de Usuarios</h1>
                        <p>Administra los usuarios del sistema, sus roles, permisos y asignaciones de clientes y obras.</p>
                    </div>

                    @if(auth()->user()?->hasRole('superadmin') || auth()->user()?->hasRole('admin'))
                        <button id="btnOpenModal" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            Agregar Usuario
                        </button>
                    @endif
                </div>

                {{-- ALERTAS --}}
                <div id="alertSuccess" class="hidden mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800" id="alertSuccessMessage">
                                Acción realizada correctamente.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="alertError" class="hidden mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 112 0 1 1 0 01-2 0zm0-6a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800" id="alertErrorMessage">
                                Ocurrió un error al procesar la solicitud.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD DE FILTROS --}}
                <div class="card-filters">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="filter-badge">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                    Filtros activos
                                </span>
                                <span id="activeFiltersCount" class="text-xs font-semibold text-indigo-600">0</span>
                            </div>

                            <button id="btnResetFilters" class="btn-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M4 20v-5h.581m15.356-2a8.003 8.003 0 01-15.356 2"/>
                                </svg>
                                Limpiar filtros
                            </button>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 md:items-center">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center">
                                    <label class="switch">
                                        <input type="checkbox" id="filterHasRole">
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ml-2 text-sm text-gray-700">Solo con rol asignado</span>
                                </div>

                                <div class="flex items-center">
                                    <label class="switch">
                                        <input type="checkbox" id="filterHasClients">
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ml-2 text-sm text-gray-700">Con clientes asignados</span>
                                </div>

                                <div class="flex items-center">
                                    <label class="switch">
                                        <input type="checkbox" id="filterHasObras">
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ml-2 text-sm text-gray-700">Con obras asignadas</span>
                                </div>
                            </div>

                            <div class="relative w-full md:w-64">
                                <input type="text" id="searchUser" class="input-search"
                                       placeholder="Buscar por nombre o email...">
                                <span class="search-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.15 13.15z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD con FORM + TABLA --}}
              {{-- CARD con FORM + TABLA --}}
<div class="card-table">

    {{-- FORM colapsable (fuera de la tabla) --}}
    <div id="formContainer" class="hidden border-b border-gray-100">
        <div class="p-6 text-gray-900">
            {{-- header form --}}
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2" style="border-color:#2c4a6b;">
                <h3 class="text-lg font-semibold" style="color:#2c4a6b;" id="formTitulo">Agregar Usuario</h3>
                <button id="btnCerrarForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- FORMULARIO --}}
            <form id="formUsuario">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="formMethod" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                               style="focus:ring-color: #2c4a6b;"
                               placeholder="Nombre completo">
                        <span class="text-red-500 text-xs hidden" id="error-name"></span>
                    </div>

                    {{-- Rol --}}
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <select id="role"
                                name="role"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                                style="focus:ring-color: #2c4a6b;">
                            <option value="">Seleccionar rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <span class="text-red-500 text-xs hidden" id="error-role"></span>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                               style="focus:ring-color: #2c4a6b;"
                               placeholder="email@ejemplo.com">
                        <span class="text-red-500 text-xs hidden" id="error-email"></span>
                    </div>

                    {{-- Celular --}}
                    <div>
                        <label for="celular" class="block text-sm font-medium text-gray-700 mb-1">
                            Celular
                        </label>
                        <input type="tel"
                               id="celular"
                               name="celular"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                               style="focus:ring-color: #2c4a6b;"
                               placeholder="(opcional)">
                    </div>

                    {{-- Clientes --}}
                    <div id="clientesContainer">
                        <label for="clientes" class="block text-sm font-medium text-gray-700 mb-1">
                            Clientes <span class="text-red-500" id="clientesRequired">*</span>
                        </label>
                        <select name="clientes[]"
                                id="clientes"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                                style="focus:ring-color: #2c4a6b; height: 120px;"
                                multiple
                                size="5">
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" class="text-gray-900 py-1">
                                    {{ $cliente->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500" id="clientesHelp">
                            Mantén Ctrl (Cmd en Mac) para seleccionar múltiples clientes
                        </p>
                        <span class="text-red-500 text-xs hidden" id="error-clientes"></span>
                    </div>
                    <div>
                       
                     <div id="passwordResetWrapper" class="hidden">
    <label for="password_reset" class="block text-sm font-medium text-gray-700 mb-1">
        Resetear contraseña
    </label>
    <input type="password"
           id="password_reset"
           name="password_reset"
           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
           placeholder="Nueva contraseña (opcional)">

    <label for="password_reset_confirmation"
           class="block text-sm font-medium text-gray-700 mb-1 mt-3">
        Confirmar contraseña
    </label>
    <input type="password"
           id="password_reset_confirmation"
           name="password_reset_confirmation"
           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
           placeholder="Confirmar contraseña">
</div>

                        </div>
                </div>

                {{-- Fecha asignación (solo editar) --}}
                <div id="fechaAsignacionContainer" class="hidden mt-4">
                    <label for="fecha_asignacion" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de asignación
                    </label>
                    <input type="date"
                           id="fecha_asignacion"
                           name="fecha_asignacion"
                           class="w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50 text-gray-900 bg-white"
                           style="focus:ring-color: #2c4a6b;">
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-2 mt-6 pt-4 border-t border-gray-200">
                    <button type="button"
                            id="btnCancelar"
                            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                        Cancelar
                    </button>
                    <button type="submit"
                            id="btnGuardar"
                            class="px-6 py-2 text-white rounded-md hover:opacity-90 transition-colors font-medium"
                            style="background-color: #2c4a6b;">
                        <span id="btnGuardarTexto">Guardar</span>
                        <span id="btnGuardarLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="overflow-x-auto w-full">
        <table class="min-w-full w-full border border-gray-200">
            <thead style="background-color:#2c4a6b;">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-blue-800">
                        Nombre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-blue-800">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-blue-800">
                        Rol
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-blue-800">
                        Clientes
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-blue-800">
                        Obras
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-150" data-user-id="{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 avatar-circle text-white font-medium text-sm"
                                         style="background-color:#2c4a6b;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>

                        {{-- Rol --}}
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            @php
                                $roleName = $user->roles->first()->name ?? null;
                                $roleKey  = $roleName ? strtolower($roleName) : null;
                            @endphp

                            @if($roleKey === 'superadmin')
                                <span class="role-badge role-superadmin">Superadmin</span>
                            @elseif($roleKey === 'admin')
                                <span class="role-badge role-admin">Admin</span>
                            @elseif($roleKey)
                                <span class="role-badge role-user">{{ ucfirst($roleName) }}</span>
                            @else
                                <span class="role-badge role-none">Sin rol</span>
                            @endif
                        </td>

                        {{-- Clientes --}}
                        <td class="px-6 py-4 border-r border-gray-200">
                            @if($user->clientes->isNotEmpty())
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $user->clientes->count() }}
                                    {{ Str::plural('cliente', $user->clientes->count()) }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $user->clientes->pluck('name')->take(2)->implode(', ') }}
                                    @if($user->clientes->count() > 2)
                                        <span class="text-gray-400">+{{ $user->clientes->count() - 2 }} más</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Sin clientes</span>
                            @endif
                        </td>

                        {{-- Obras --}}
                        <td class="px-6 py-4 border-r border-gray-200">
                            @if($user->obras->isNotEmpty())
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $user->obras->count() }}
                                    {{ Str::plural('obra', $user->obras->count()) }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $user->obras->pluck('name')->take(2)->implode(', ') }}
                                    @if($user->obras->count() > 2)
                                        <span class="text-gray-400">+{{ $user->obras->count() - 2 }} más</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Sin obras</span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <button class="btn-outline text-gray-600 hover:text-gray-900"
                                        data-action="view"
                                        data-user-id="{{ $user->id }}"
                                        title="Ver detalles del usuario">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                @if(auth()->user()?->hasRole('superadmin') || auth()->user()?->hasRole('admin'))
                                    <button class="btn-outline text-gray-700 hover:text-blue-600 hover:border-blue-600"
                                            data-action="edit"
                                            data-user-id="{{ $user->id }}"
                                            title="Editar usuario">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <button class="btn-danger"
                                            data-action="delete"
                                            data-user-id="{{ $user->id }}"
                                            title="Eliminar usuario">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4-4h.01" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No hay usuarios registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


    {{-- Select2 --}}
  


</x-app-layout>


  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
     const usersBaseUrl = "{{ url('users') }}"; 
console.log('🔍 Script cargando...');

// Esperar a que el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUsuariosScript);
} else {
    initUsuariosScript();
}


// Inicializar Select2 para clientes
$('#clientes').select2({
    placeholder: 'Selecciona clientes...',
    allowClear: false,
    closeOnSelect: false,  // ← Importante: mantener abierto al seleccionar
    width: '100%',
    multiple: true,  // ← Forzar modo múltiple
    language: {
        noResults: function() {
            return "No se encontraron clientes";
        }
    }
});

// Lógica según el rol seleccionado
$('#role').on('change', function() {
    const role = $(this).val();
    const $clientesSelect = $('#clientes');
    const $clientesRequired = $('#clientesRequired');
    const $clientesHelp = $('#clientesHelp');

    if (role === 'superadmin') {
        $clientesSelect.prop('required', false);
        $clientesRequired.hide();
        $clientesHelp.text('Opcional. Si no asignas clientes, tendrá acceso a todos.');
    } else if (role === 'admin') {
        $clientesSelect.prop('required', false);
        $clientesRequired.hide();
        $clientesHelp.text('Opcional. Si no asignas clientes, tendrá acceso a todos. Si asignas, solo verá esos clientes.');
    } else if (role === 'user') {
        $clientesSelect.prop('required', true);
        $clientesRequired.show();
        $clientesHelp.text('Requerido. Selecciona al menos un cliente.');
    }
});

// Al resetear el formulario, limpiar también Select2
function resetForm() {
    $('#userForm')[0].reset();
    $('#clientes').val(null).trigger('change'); // Limpiar Select2
    $('#user_id').val('');
    $('#formTitle').text('Agregar Usuario');
}


function initUsuariosScript() {
    console.log('✅ DOM cargado');
    
    // Verificar jQuery
    if (typeof jQuery === 'undefined') {
        console.error('❌ jQuery NO disponible');
        alert('Error: jQuery no está cargado');
        return;
    }
    
    console.log('✅ jQuery disponible:', jQuery.fn.jquery);
    
    // Verificar botón - AHORA BUSCA #btnOpenModal
    const btnAgregar = $('#btnOpenModal');
    console.log('🔍 Botón encontrado:', btnAgregar.length > 0 ? 'SÍ' : 'NO');
    
    if (btnAgregar.length === 0) {
        console.error('❌ Botón #btnOpenModal no encontrado');
        return;
    }

    const BLUE_COLOR = '#2c4a6b';
    let isEditMode = false;
    let allUsers = []; // Guardamos todos los usuarios para filtrado

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function showForm() {
        console.log('📂 Mostrando formulario');
        $('#formContainer').removeClass('hidden').hide().slideDown(300);
        // Scroll suave hacia el formulario
        setTimeout(() => {
            $('html, body').animate({
                scrollTop: $('#formContainer').offset().top - 100
            }, 500);
        }, 100);
    }

    function hideForm() {
        console.log('📁 Ocultando formulario');
        $('#formContainer').slideUp(300, function() {
            $(this).addClass('hidden');
        });
        resetForm();
    }

    function resetForm() {
        console.log('🔄 Reseteando formulario');
        $('#formUsuario')[0].reset();
        $('#userId').val('');
        $('#formMethod').val('POST');
        isEditMode = false;
        $('.text-red-500').addClass('hidden');
        $('input, select').removeClass('border-red-500');
        $('#formTitulo').text('Agregar Usuario');
        $('#btnGuardarTexto').text('Guardar');
        $('#fechaAsignacionContainer').addClass('hidden');
    }

    function showAlert(type, message) {
        const alertId = type === 'success' ? '#alertSuccess' : '#alertError';
        const messageId = type === 'success' ? '#alertSuccessMessage' : '#alertErrorMessage';
        
        $(messageId).text(message);
        $(alertId).removeClass('hidden');
        
        setTimeout(() => {
            $(alertId).addClass('hidden');
        }, 5000);

        $('html, body').animate({ scrollTop: 0 }, 500);
    }

    function showFieldError(field, message) {
        $(`#${field}`).addClass('border-red-500');
        $(`#error-${field}`).text(message).removeClass('hidden');
    }

    function clearFieldError(field) {
        $(`#${field}`).removeClass('border-red-500');
        $(`#error-${field}`).addClass('hidden');
    }

    function clearAllErrors() {
        $('input, select').removeClass('border-red-500');
        $('.text-red-500').addClass('hidden');
    }

    // ============================================
    // FUNCIONES DE FILTRADO
    // ============================================

    function updateActiveFiltersCount() {
        let count = 0;
        if ($('#filterHasRole').is(':checked')) count++;
        if ($('#filterHasClients').is(':checked')) count++;
        if ($('#filterHasObras').is(':checked')) count++;
        if ($('#searchUser').val().trim() !== '') count++;
        
        $('#activeFiltersCount').text(count);
    }

    function applyFilters() {
        const searchTerm = $('#searchUser').val().toLowerCase().trim();
        const filterHasRole = $('#filterHasRole').is(':checked');
        const filterHasClients = $('#filterHasClients').is(':checked');
        const filterHasObras = $('#filterHasObras').is(':checked');

        console.log('🔍 Aplicando filtros:', { searchTerm, filterHasRole, filterHasClients, filterHasObras });

        let visibleCount = 0;

        $('#usersTableBody tr').each(function() {
            const $row = $(this);
            const userName = $row.find('td:eq(0)').text().toLowerCase();
            const userEmail = $row.find('td:eq(1)').text().toLowerCase();
            const hasRole = $row.find('td:eq(2) .role-badge').text().trim() !== 'Sin rol';
            const clientesText = $row.find('td:eq(3)').text().toLowerCase();
            const hasClientes = !clientesText.includes('sin clientes');
            const obrasText = $row.find('td:eq(4)').text().toLowerCase();
            const hasObras = !obrasText.includes('sin obras');

            let show = true;

            // Filtro de búsqueda
            if (searchTerm !== '') {
                if (!userName.includes(searchTerm) && !userEmail.includes(searchTerm)) {
                    show = false;
                }
            }

            // Filtro de rol
            if (filterHasRole && !hasRole) {
                show = false;
            }

            // Filtro de clientes
            if (filterHasClients && !hasClientes) {
                show = false;
            }

            // Filtro de obras
            if (filterHasObras && !hasObras) {
                show = false;
            }

            if (show) {
                $row.show();
                visibleCount++;
            } else {
                $row.hide();
            }
        });

        console.log(`✅ Mostrando ${visibleCount} usuarios`);
        updateActiveFiltersCount();
    }

    function resetFilters() {
        console.log('🔄 Limpiando filtros');
        $('#searchUser').val('');
        $('#filterHasRole').prop('checked', false);
        $('#filterHasClients').prop('checked', false);
        $('#filterHasObras').prop('checked', false);
        applyFilters();
    }

    // ============================================
    // EVENT LISTENERS DE FILTROS
    // ============================================

    $('#searchUser').on('input', function() {
        applyFilters();
    });

    $('#filterHasRole, #filterHasClients, #filterHasObras').on('change', function() {
        applyFilters();
    });

    $('#btnResetFilters').on('click', function(e) {
        e.preventDefault();
        resetFilters();
    });

    // ============================================
    // ABRIR FORMULARIO PARA CREAR
    // ============================================

    $('#btnOpenModal').on('click', function(e) {
        e.preventDefault();
        console.log('🔵 Click en botón Agregar Usuario');
        resetForm();
        showForm();
    });

    // ============================================
    // VALIDACIÓN EN TIEMPO REAL
    // ============================================

    $('#name').on('input', function() {
        const value = $(this).val().trim();
        if (value.length === 0) {
            showFieldError('name', 'El nombre es obligatorio');
        } else if (value.length < 3) {
            showFieldError('name', 'El nombre debe tener al menos 3 caracteres');
        } else {
            clearFieldError('name');
        }
    });

    $('#email').on('input', function() {
        const value = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value.length === 0) {
            showFieldError('email', 'El email es obligatorio');
        } else if (!emailRegex.test(value)) {
            showFieldError('email', 'El email no es válido');
        } else {
            clearFieldError('email');
        }
    });

    $('#role').on('change', function() {
        const value = $(this).val();
        if (value.length === 0) {
            showFieldError('role', 'Debes seleccionar un rol');
        } else {
            clearFieldError('role');
        }
    });

    // ============================================
    // CERRAR FORMULARIO
    // ============================================

    $('#btnCerrarForm, #btnCancelar').on('click', function(e) {
        e.preventDefault();
        hideForm();
    });

    // ============================================
    // ABRIR FORMULARIO PARA EDITAR
    // ============================================

    $(document).on('click', '[data-action="edit"]', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        isEditMode = true;
        
        console.log('✏️ Editando usuario:', userId);
        
        // Mostrar formulario con loading
        resetForm();
        $('#btnGuardarTexto').text('Cargando...');
        showForm();

        $.ajax({
            // url: `/users/${userId}/edit`,
            url: `${usersBaseUrl}/${userId}/edit`,

            method: 'GET',
            success: function(response) {
                console.log('✅ Datos del usuario cargados:', response);
                $('#userId').val(response.user.id);
                $('#name').val(response.user.name);
                $('#email').val(response.user.email);
                $('#role').val(response.user.role);
                $('#celular').val(response.user.phone || ''); // ← Agregado
                $('#formMethod').val('PUT');
                $('#formTitulo').text('Editar Usuario');
                $('#btnGuardarTexto').text('Actualizar');
                $('#password_reset').val('');
                $('#password_reset_confirmation').val('');
                if (response.can_reset_password) {
                    $('#passwordResetWrapper').removeClass('hidden');
                    } else {
                    $('#passwordResetWrapper').addClass('hidden');
                    }
                // Mostrar fecha de asignación si existe
                if (response.user.created_at) {
                    $('#fecha_asignacion').val(response.user.created_at);
                    $('#fechaAsignacionContainer').removeClass('hidden');
                }
            },
            error: function(xhr) {
                console.error('❌ Error al cargar usuario:', xhr);
                hideForm();
                showAlert('error', 'Error al cargar los datos del usuario');
            }
        });
    });

    // ============================================
    // VER DETALLES DEL USUARIO
    // ============================================

    $(document).on('click', '[data-action="view"]', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        console.log('👁️ Ver detalles del usuario:', userId);
        
        // Redirigir a la página de detalles
        // window.location.href = `/users/${userId}`;
        window.location.href = `${usersBaseUrl}/${userId}`;

    });

    // ============================================
    // ENVIAR FORMULARIO (CREAR/EDITAR)
    // ============================================

  $('#formUsuario').on('submit', function(e) {
    // 1) SIEMPRE cancelamos el envío normal del formulario
    e.preventDefault();
      e.stopPropagation();
  console.log('[FORM] submit interceptado');
  
    const role = $('#role').val();
    const clientes = $('#clientes').val();

    // Solo validar para USER
    if (role === 'user' && (!clientes || clientes.length === 0)) {
        alert('⚠️ Los usuarios con rol "user" deben tener al menos un cliente asignado.');
        $('#clientes').focus();
        return; // <- ya no hace falta e.preventDefault() aquí
    }

    clearAllErrors();

    const clientesSeleccionados = $('#clientes').val() || [];

    const formData = {
        name: $('#name').val().trim(),
        email: $('#email').val().trim(),
        role: $('#role').val(),
        phone: $('#celular').val().trim(),
        clientes: clientesSeleccionados,
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    const method = $('#formMethod').val();
    const userId = $('#userId').val();

    // RECOMENDADO: usar url() de Laravel para no pelear con /cubic/public
    const usersBaseUrl = "{{ url('users') }}";
    const url = method === 'PUT'
        ? `${usersBaseUrl}/${userId}`
        : usersBaseUrl;

    // Mostrar loading
    $('#btnGuardar').prop('disabled', true);
    $('#btnGuardarTexto').addClass('hidden');
    $('#btnGuardarLoading').removeClass('hidden');

    $.ajax({
        url: url,
        method: 'POST',
        data: method === 'PUT' ? { ...formData, _method: 'PUT' } : formData,
        success: function(response) {
            console.log('✅ Usuario guardado:', response);
            hideForm();
            showAlert('success', response.message || (method === 'PUT'
                ? 'Usuario actualizado exitosamente'
                : 'Usuario creado exitosamente'));

            setTimeout(() => {
                // window.location.reload();
            }, 1500);
        },
        error: function(xhr) {
            console.error('❌ Error al guardar:', xhr);
            $('#btnGuardar').prop('disabled', false);
            $('#btnGuardarTexto').removeClass('hidden');
            $('#btnGuardarLoading').addClass('hidden');

            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    showFieldError(field, messages[0]);
                });
            } else {
                showAlert('error', xhr.responseJSON?.message || 'Error al guardar el usuario');
            }
        }
    });
    return false;
});
    // ============================================
    // ELIMINAR USUARIO
    // ============================================

    $(document).on('click', '[data-action="delete"]', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const $row = $(this).closest('tr');
        const userName = $row.find('td:eq(0) .text-sm').text().trim();

        if (confirm(`¿Estás seguro de eliminar al usuario "${userName}"?\n\nEsta acción no se puede deshacer.`)) {
            console.log('🗑️ Eliminando usuario:', userId);
            
            $.ajax({
                // url: `/users/${userId}`,
                url: `${usersBaseUrl}/${userId}`,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('✅ Usuario eliminado:', response);
                    showAlert('success', response.message || 'Usuario eliminado exitosamente');
                    
                    $(`tr[data-user-id="${userId}"]`).fadeOut(300, function() {
                        $(this).remove();
                        
                        if ($('#usersTableBody tr:visible').length === 0) {
                            setTimeout(() => {
                                // window.location.reload();
                            }, 1000);
                        }
                    });
                },
                error: function(xhr) {
                    console.error('❌ Error al eliminar:', xhr);
                    showAlert('error', xhr.responseJSON?.message || 'Error al eliminar el usuario');
                }
            });
        }
    });

    // Inicializar contador de filtros
    updateActiveFiltersCount();

    console.log('✅ Script de usuarios completamente inicializado');
}
</script>
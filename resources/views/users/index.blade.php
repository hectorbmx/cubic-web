<style>
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

        .btn-secondary:hover {
            background: #f3f4f6;
        }

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

        .btn-danger:hover {
            background-color: #be123c;
        }

        .btn-outline {
            border-radius: 9999px;
            border: 1px solid #d1d5db;
            padding: 0.25rem 0.75rem;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-outline:hover {
            background-color: #f3f4f6;
        }

        .filter-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .filter-pill.active {
            background-color: #2c4a6b;
            color: white;
        }

        .filter-pill.inactive {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .filter-pill.inactive:hover {
            border-color: #d1d5db;
        }

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

        .status-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-pill.active {
            background-color: #ecfdf3;
            color: #15803d;
        }

        .status-pill.inactive {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .3s;
            border-radius: 9999px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .3s;
            border-radius: 9999px;
        }

        input:checked + .slider {
            background-color: #2c4a6b;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .badge-pill {
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-pill span {
            white-space: nowrap;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 160px;
            background-color: #111827;
            color: #f9fafb;
            text-align: center;
            border-radius: 6px;
            padding: 0.5rem;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .modal-backdrop-custom {
            background-color: rgba(15, 23, 42, 0.65);
        }

        .modal-panel {
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 10px 10px -5px rgba(15, 23, 42, 0.04);
        }

        .avatar-circle {
            border-radius: 9999px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .avatar-circle span {
            letter-spacing: 0.03em;
        }

        .filter-badge {
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 12px;
            border: 1px solid #d1d5db;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .filter-badge span {
            white-space: nowrap;
        }

        /* Badges de rol */
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

        .role-superadmin {
            background-color: #F3E8FF; /* purple-100 */
            color: #6B21A8; /* purple-800 */
        }

        .role-admin {
            background-color: #2c4a6b;
            color: #ffffff;
        }

        .role-user {
            background-color: #E5E7EB; /* gray-200 */
            color: #111827; /* gray-900 */
        }

        .role-none {
            background-color: #F3F4F6; /* gray-100 */
            color: #4B5563; /* gray-600 */
        }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Gestión de Usuarios') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Administra los usuarios del sistema, sus roles, permisos y asignaciones de clientes y obras.
                </p>
            </div>
            @if(auth()->user()?->hasRole('superadmin') || auth()->user()?->hasRole('admin'))
                <button id="btnOpenModal" 
                    class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar Usuario
                </button>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensajes de éxito/error --}}
            <div id="alertSuccess" class="hidden mb-4 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
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
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 112 0 1 1 0 01-2 0zm0-6a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800" id="alertErrorMessage">
                            Ocurrió un error al procesar la solicitud.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Filtros y búsqueda --}}
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="filter-badge">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Filtros activos</span>
                            <span id="activeFiltersCount" class="text-xs font-semibold text-indigo-600">0</span>
                        </div>

                        <button id="btnResetFilters" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M4 20v-5h.581m15.356-2a8.003 8.003 0 01-15.356 2" />
                            </svg>
                            Limpiar filtros
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 md:items-center">
                        <div class="flex items-center gap-3">
                            <div class="tooltip">
                                <label class="switch">
                                    <input type="checkbox" id="filterHasRole">
                                    <span class="slider"></span>
                                </label>
                                <span class="ml-2 text-sm text-gray-700">Solo con rol asignado</span>
                                <span class="tooltiptext">Muestra solo usuarios que tienen al menos un rol asignado.</span>
                            </div>

                            <div class="tooltip">
                                <label class="switch">
                                    <input type="checkbox" id="filterHasClients">
                                    <span class="slider"></span>
                                </label>
                                <span class="ml-2 text-sm text-gray-700">Con clientes asignados</span>
                                <span class="tooltiptext">Filtra usuarios que ya tienen uno o más clientes asociados.</span>
                            </div>

                            <div class="tooltip">
                                <label class="switch">
                                    <input type="checkbox" id="filterHasObras">
                                    <span class="slider"></span>
                                </label>
                                <span class="ml-2 text-sm text-gray-700">Con obras asignadas</span>
                                <span class="tooltiptext">Muestra usuarios que tienen al menos una obra asignada.</span>
                            </div>
                        </div>

                        <div class="relative w-full md:w-64">
                            <input type="text" id="searchUser" class="input-search" placeholder="Buscar por nombre o email...">
                            <span class="search-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.15 13.15z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de usuarios --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Tabla de usuarios estilo Bootstrap --}}
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full w-full border border-gray-200">
                        <thead style="background-color: #2c4a6b;">
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
                        {{-- Formulario colapsable para Crear/Editar Usuario --}}
<div id="formContainer" class="hidden bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900">
        {{-- Header del Formulario --}}
        <div class="flex justify-between items-center pb-4 mb-4 border-b-2" style="border-color: #2c4a6b;">
            <h3 class="text-lg font-semibold" style="color: #2c4a6b;" id="formTitulo">Agregar Usuario</h3>
            <button id="btnCerrarForm" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Formulario --}}
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

                {{-- Celular (opcional) --}}
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
            </div>

            {{-- Fecha de asignación (solo visible al editar) --}}
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
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Guardando...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150" data-user-id="{{ $user->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 avatar-circle text-white font-medium text-sm" 
                                                     style="background-color: #2c4a6b;">
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

                                    {{-- Columna Rol con badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                        @php
                                            $roleName = $user->roles->first()->name ?? null;
                                            $roleKey = $roleName ? strtolower($roleName) : null;
                                        @endphp

                                        @if($roleKey === 'superadmin')
                                            <span class="role-badge role-superadmin">
                                                Superadmin
                                            </span>
                                        @elseif($roleKey === 'admin')
                                            <span class="role-badge role-admin">
                                                Admin
                                            </span>
                                        @elseif($roleKey)
                                            <span class="role-badge role-user">
                                                {{ ucfirst($roleName) }}
                                            </span>
                                        @else
                                            <span class="role-badge role-none">
                                                Sin rol
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 border-r border-gray-200">
                                        @if($user->clientes->isNotEmpty())
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $user->clientes->count() }} 
                                                {{ Str::plural('cliente', $user->clientes->count()) }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $user->clientes->pluck('nombre')->take(2)->implode(', ') }}
                                                @if($user->clientes->count() > 2)
                                                    <span class="text-gray-400">+{{ $user->clientes->count() - 2 }} más</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Sin clientes</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-200">
                                        @if($user->obras->isNotEmpty())
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $user->obras->count() }} 
                                                {{ Str::plural('obra', $user->obras->count()) }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $user->obras->pluck('nombre')->take(2)->implode(', ') }}
                                                @if($user->obras->count() > 2)
                                                    <span class="text-gray-400">+{{ $user->obras->count() - 2 }} más</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Sin obras</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <button class="btn-outline text-gray-600 hover:text-gray-900" 
                                                    data-action="view" data-user-id="{{ $user->id }}" 
                                                    title="Ver detalles del usuario">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                            @if(auth()->user()?->hasRole('superadmin') || auth()->user()?->hasRole('admin'))
                                                <button class="btn-outline text-blue-600 hover:text-blue-800" 
                                                        data-action="edit" data-user-id="{{ $user->id }}"
                                                        title="Editar usuario">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>

                                                <button class="btn-danger" 
                                                        data-action="delete" data-user-id="{{ $user->id }}"
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
        </div>
    </div>

    {{-- Modal de usuario (resto del código igual que ya lo tenías)… --}}
    {{-- … --}}
</x-app-layout>


<script>
console.log('🔍 Script cargando...');

// Esperar a que el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUsuariosScript);
} else {
    initUsuariosScript();
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
            url: `/users/${userId}/edit`,
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
        window.location.href = `/users/${userId}`;
    });

    // ============================================
    // ENVIAR FORMULARIO (CREAR/EDITAR)
    // ============================================

    $('#formUsuario').on('submit', function(e) {
        e.preventDefault();
        console.log('📤 Enviando formulario');
        console.log('🔍 isEditMode:', isEditMode);
        console.log('🔍 userId desde input:', $('#userId').val());
        console.log('🔍 method desde input:', $('#formMethod').val());
        clearAllErrors();

        const formData = {
            name: $('#name').val().trim(),
            email: $('#email').val().trim(),
            role: $('#role').val(),
            phone: $('#celular').val().trim(), // ← Agregado (nota que el ID es "celular")

            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log('📋 Datos del formulario:', formData);

        const method = $('#formMethod').val();
        const userId = $('#userId').val();
        // const url = isEditMode ? `/users/${userId}` : '/users';
        const url = method === 'PUT' ? `/users/${userId}` : '/users';

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
                // showAlert('success', response.message || (isEditMode ? 'Usuario actualizado exitosamente' : 'Usuario creado exitosamente'));
                showAlert('success', response.message || (method === 'PUT' ? 'Usuario actualizado exitosamente' : 'Usuario creado exitosamente'));
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.error('❌ Error al guardar:', xhr);
                $('#btnGuardar').prop('disabled', false);
                $('#btnGuardarTexto').removeClass('hidden');
                $('#btnGuardarLoading').addClass('hidden');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    console.log('📝 Errores de validación:', errors);
                    $.each(errors, function(field, messages) {
                        showFieldError(field, messages[0]);
                    });
                } else {
                    showAlert('error', xhr.responseJSON?.message || 'Error al guardar el usuario');
                }
            }
        });
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
                url: `/users/${userId}`,
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
                                window.location.reload();
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
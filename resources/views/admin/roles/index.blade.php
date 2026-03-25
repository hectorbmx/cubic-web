<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Roles y permisos</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Administración de roles y permisos del sistema. Solo disponible para superadministradores.
                </p>
            </div>
@php
    $rolesForJs = $roles->map(function ($role) {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'permission_ids' => $role->permissions->pluck('id')->values()->toArray(),
        ];
    })->values();
@endphp
            <div
               x-data="{
                        tab: 'roles',
                        selectedRoleId: '',
                        showPermissionModal: false,
                        roles: {{ Js::from($rolesForJs) }},
                        selectedPermissionIds: [],
                        updateSelectedPermissions() {
                            const selectedRole = this.roles.find(role => String(role.id) === String(this.selectedRoleId));
                            this.selectedPermissionIds = selectedRole ? selectedRole.permission_ids : [];
                        }
                    }"
                class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden"
            >
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button
                            type="button"
                            @click="tab = 'roles'"
                            :class="tab === 'roles'
                                ? 'border-blue-600 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 text-sm font-medium border-b-2 transition"
                        >
                            Roles
                        </button>

                        <button
                            type="button"
                            @click="tab = 'permisos'"
                            :class="tab === 'permisos'
                                ? 'border-blue-600 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 text-sm font-medium border-b-2 transition"
                        >
                            Permisos
                        </button>
                        <button
                            type="button"
                            @click="tab = 'asignaciones'"
                            :class="tab === 'asignaciones'
                                ? 'border-blue-600 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 text-sm font-medium border-b-2 transition"
                        >
                            Asignación de permisos
                        </button>
                    </nav>
                </div>

                <!-- Contenido tab Roles -->
              <div x-show="tab === 'roles'" x-transition class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Roles</h2>
            <p class="mt-1 text-sm text-gray-500">
                Aquí verás los roles disponibles del sistema.
            </p>
        </div>

        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition"
        >
            Nuevo rol
        </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Rol</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Guard</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Permisos asignados</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $role->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $role->guard_name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $role->permissions_count }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">
                            No hay roles registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

                <!-- Contenido tab Permisos -->
              <div x-show="tab === 'permisos'" x-transition class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Permisos</h2>
            <p class="mt-1 text-sm text-gray-500">
                Aquí verás los permisos disponibles del sistema.
            </p>
        </div>

       <button
                type="button"
                @click="showPermissionModal = true"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition"
            >
                Nuevo permiso
            </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Permiso</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Guard</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $permission->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $permission->guard_name }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500">
                            No hay permisos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- tab para asignar permisos -->
<div x-show="tab === 'asignaciones'" x-transition class="p-6">
   <form method="POST" action="{{ route('admin.roles.sync-permissions') }}">
    @csrf
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Asignación de permisos</h2>
            <p class="mt-1 text-sm text-gray-500">
                Selecciona un rol para visualizar y administrar sus permisos.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda -->
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Rol
                </label>

              <select
                    id="role_id"
                    name="role_id"
                    x-model="selectedRoleId"
                    @change="updateSelectedPermissions()"
                    class="text-black w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <p class="mt-3 text-xs text-gray-500">
                    En el siguiente paso conectaremos este selector para cargar y guardar permisos del rol seleccionado.
                </p>
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-gray-900">Permisos del rol</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Aquí aparecerán los permisos disponibles para asignar o quitar.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                x-model="selectedPermissionIds"
                                value="{{ $permission->id }}"
                            >
                             <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                   <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition"
                >
                    Actualizar permisos
                </button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<!-- Modal: Nuevo permiso -->
<div
    x-show="showPermissionModal"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
    style="display: none;"
>
    <div
        @click.away="showPermissionModal = false"
        class="w-full max-w-md rounded-2xl bg-white shadow-xl"
    >
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">Nuevo permiso</h3>

            <button
                type="button"
                @click="showPermissionModal = false"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none"
            >
                &times;
            </button>
        </div>

        <form method="POST" action="{{ route('admin.permissions.store') }}" class="p-6">
            @csrf

            <div>
                <label for="permission_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre del permiso
                </label>

                <input
                    type="text"
                    id="permission_name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ej. acceso-web"
                    class="text-black w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button
                    type="button"
                    @click="showPermissionModal = false"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition"
                >
                    Guardar permiso
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
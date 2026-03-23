<x-app-layout>
    <style>
        .user-show-page {
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

        .hero-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .hero-title h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .hero-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 0.25rem;
        }

        .hero-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
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

        .hero-main {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .avatar-circle {
            width: 64px;
            height: 64px;
            border-radius: 9999px;
            background: rgba(15, 23, 42, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            text-transform: uppercase;
        }

        .user-info-main h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
        }

        .user-info-main p {
            margin: 0;
            font-size: 14px;
            opacity: 0.95;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.15rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .role-superadmin {
            background-color: #F3E8FF;
            color: #6B21A8;
        }
        .role-admin {
            background-color: #2c4a6b;
            color: #ffffff;
        }
        .role-user, .role-none {
            background-color: #E5E7EB;
            color: #111827;
        }

        .cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 1.5rem 1.75rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        .card-subtitle {
            font-size: 12px;
            color: #6b7280;
        }

        .list-bullets {
            list-style: disc;
            padding-left: 1.25rem;
            margin: 0;
        }

        .list-bullets li {
            font-size: 14px;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .list-meta {
            font-size: 12px;
            color: #6b7280;
        }

        .badge-inline {
            border-radius: 9999px;
            background: #f3f4f6;
            padding: 0.15rem 0.5rem;
            font-size: 11px;
            color: #4b5563;
            margin-left: 0.25rem;
        }
          .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(17,24,39,.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 1rem;
    }
    .modal-backdrop.show { display: flex; }

    .modal-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0,0,0,.25);
        overflow: hidden;
    }
    .modal-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .75rem;
    }
    .modal-title {
        font-weight: 700;
        color: #111827;
        font-size: 16px;
    }
    .modal-close {
        background: #f3f4f6;
        border: none;
        border-radius: 10px;
        padding: .5rem .75rem;
        cursor: pointer;
        font-weight: 600;
        color: #374151;
    }
    .modal-body { padding: 1rem 1.25rem; }
    .modal-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
    }
    .field-label { display:block; font-size: 13px; font-weight: 600; color:#374151; margin-bottom: .35rem; }
    .field-select, .field-input {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: .6rem .75rem;
        font-size: 14px;
        outline: none;
        color:black;
    }
    .field-select:focus, .field-input:focus {
        border-color: #f5b800;
        box-shadow: 0 0 0 3px rgba(252,194,0,.2);
    }
    .help-text { font-size: 12px; color:#6b7280; margin-top:.35rem; }
    .cards-divider {
    grid-column: 1 / -1; /* ocupa todo el ancho del grid */
    height: 1px;
    background: #e5e7eb; /* gris fino */
    margin: 0.75rem 0 1.25rem 0;
}

    </style>

    <div class="user-show-page">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Hero / encabezado --}}
                <div class="page-hero">
                    <div class="hero-header">
                        <div class="hero-title">
                            <h1>Detalle de usuario</h1>
                            <p class="hero-subtitle">
                                Revisa la información del usuario, los clientes y las obras que tiene asignadas.
                            </p>
                        </div>
                        <div class="hero-actions">
                            <a href="{{ route('usuarios.obras', $user) }}" class="btn-primary">
                                📊 Gestionar obras
                            </a>
                            <a href="{{ route('users.index') }}" class="btn-secondary">
                                ← Volver al listado
                            </a>
                        </div>
                    </div>

                    <div class="hero-main">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="user-info-main">
                            <h2>{{ $user->name }}</h2>
                            <p>{{ $user->email }}</p>
                            @if($user->phone)
                                <p>📱 {{ $user->phone }}</p>
                            @endif

                            @php
                                $roleName = $user->roles->first()->name ?? null;
                                $roleKey = $roleName ? strtolower($roleName) : 'none';
                            @endphp

                            <span class="role-badge role-{{ $roleKey === 'superadmin' ? 'superadmin' : ($roleKey === 'admin' ? 'admin' : ($roleKey === 'user' ? 'user' : 'none')) }}">
                                {{ $roleName ? ucfirst($roleName) : 'Sin rol' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tarjetas de info --}}
                <div class="cards-row">

                    {{-- Clientes asignados --}}
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Clientes asignados</div>
                                <div class="card-subtitle">
                                    (Edición desde Gestión de Usuarios)
                                </div>
                            </div>
                            <div class="card-subtitle">
                                {{ $user->clientes->count() }} {{ Str::plural('cliente', $user->clientes->count()) }}
                            </div>
                        </div>

                        @if($user->clientes->isNotEmpty())
                            <ul class="list-bullets">
                                @foreach($user->clientes as $cliente)
                                    <li>
                                        {{ $cliente->name }}
                                        @if($cliente->pivot?->role)
                                            <span class="badge-inline">
                                                Rol: {{ $cliente->pivot->role }}
                                            </span>
                                        @endif
                                        @if($cliente->pivot?->status)
                                            <span class="badge-inline">
                                                {{ ucfirst($cliente->pivot->status) }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            
                        @else
                            <p class="card-subtitle">Este usuario aún no tiene clientes asignados.</p>
                        @endif
                        <button type="button" class="btn-primary" id="btnOpenClientesModal">
                            👥 Gestionar clientes
                        </button>
                    </div>

                    {{-- Obras asignadas --}}
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-title">Obras asignadas</div>
                                <div class="card-subtitle">
                                    Listado rápido de las obras donde participa este usuario.
                                </div>
                            </div>
                            <div class="card-subtitle">
                                {{ $user->obras->count() }} {{ Str::plural('obra', $user->obras->count()) }}
                            </div>
                        </div>

                        @if($user->obras->isNotEmpty())
                            <ul class="list-bullets">
                                @foreach($user->obras as $obra)
                                    <li>
                                        {{ $obra->name }}
                                        <span class="list-meta">
                                            — {{ $obra->cliente->name ?? 'Sin cliente' }}
                                        </span>
                                        @if($obra->pivot?->role)
                                            <span class="badge-inline">
                                                Rol: {{ $obra->pivot->role }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="card-subtitle">No hay obras asignadas a este usuario.</p>
                        @endif

                        <div style="margin-top: 1.25rem;">
                            <a href="{{ route('usuarios.obras', $user) }}" class="btn-primary">
                                ⚙ Gestionar obras
                            </a>
                        </div>
                    </div>
                </div>
                {{-- SEGUNDO ROW--}}
                    <div class="cards-divider"></div>
<div class="cards-row">
    {{-- Datos del usuario --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Datos del usuario</div>
            <div class="card-subtitle">Ver y editar información básica, rol y clientes asignados.</div>
        </div>

        <button type="button" class="btn-primary" id="btnOpenUserEditModal">
            ✏️ Editar
        </button>
    </div>

    <div class="list-meta" style="line-height: 1.8;">
        <div><strong>Nombre:</strong> {{ $user->name }}</div>
        <div><strong>Email:</strong> {{ $user->email }}</div>
        <div><strong>Teléfono:</strong> {{ $user->phone ?? '—' }}</div>
        <div><strong>Rol:</strong> {{ $roleActual ?? 'Sin rol' }}</div>
        <div>
            <strong>Clientes:</strong>
            {{ $user->clientes->isNotEmpty() ? $user->clientes->pluck('name')->join(', ') : '—' }}
        </div>
    </div>
</div>

    {{--DE AQUI PARA ABAJO EL CARDD CONTRASEÑA--}}
    {{-- Seguridad --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Seguridad</div>
            <div class="card-subtitle">Resetea la contraseña del usuario (acción administrativa).</div>
        </div>

        <button type="button" class="btn-primary" id="btnOpenResetPassModal">
            🔐 Resetear contraseña
        </button>
    </div>

    <p class="card-subtitle" style="margin-top:.25rem;">
        Esta acción generará una contraseña temporal. Compártela con el usuario por un canal seguro.
    </p>
</div>

</div>
            </div>
            
        </div>
        
    </div>
    {{-- =========================
     MODAL: RESET PASSWORD
     ========================= --}}
<div class="modal-backdrop" id="resetPassModal">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="resetPassModalTitle">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="resetPassModalTitle">Resetear contraseña</div>
                <div class="card-subtitle">Se generará una contraseña temporal para {{ $user->email }}.</div>
            </div>
            <button type="button" class="modal-close" id="btnCloseResetPassModal">Cerrar</button>
        </div>

        <div class="modal-body">
            <div id="resetPassAlert" class="card-subtitle" style="display:none; margin-bottom:.75rem;"></div>

            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:.75rem;">
                <div class="list-meta">
                    Para confirmar, escribe <strong>YES</strong> y presiona "Resetear".
                </div>

                <div style="margin-top:.5rem;">
                    <input id="resetConfirmInput" class="field-input" placeholder="YES" />
                </div>
            </div>

            <div id="tempPasswordBox" style="display:none; margin-top:1rem;">
                <label class="field-label">Contraseña temporal</label>
                <div style="display:flex; gap:.5rem;">
                    <input id="tempPasswordInput" class="field-input" readonly>
                    <button type="button" class="btn-secondary" id="btnCopyTempPass">Copiar</button>
                </div>
                <div class="help-text">Compártela con el usuario por un canal seguro. Idealmente que la cambie al iniciar sesión.</div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="btnCancelResetPassModal">Cancelar</button>
            <button type="button" class="btn-primary" id="btnDoResetPass">
                ⚠️ Resetear
            </button>
        </div>
    </div>
</div>
    {{-- =========================
     MODAL: EDITAR USUARIO
     ========================= --}}
<div class="modal-backdrop" id="userEditModal">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="userEditModalTitle">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="userEditModalTitle">Editar usuario</div>
                <div class="card-subtitle">Actualiza datos, rol y clientes. Se guardará sin recargar la página.</div>
            </div>
            <button type="button" class="modal-close" id="btnCloseUserEditModal">Cerrar</button>
        </div>

        <form id="formUserUpdate" action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div id="userEditAlert" class="card-subtitle" style="display:none; margin-bottom:.75rem;"></div>

                <label class="field-label">Nombre</label>
                <input name="name" class="field-input" value="{{ $user->name }}" required>

                <div style="margin-top:.75rem;">
                    <label class="field-label">Email</label>
                    <input type="email" name="email" class="field-input" value="{{ $user->email }}" required>
                </div>

                <div style="margin-top:.75rem;">
                    <label class="field-label">Teléfono</label>
                    <input name="phone" class="field-input" value="{{ $user->phone ?? '' }}" placeholder="Opcional">
                </div>

                <div style="margin-top:.75rem;">
                    <label class="field-label">Rol</label>
                    <select name="role" class="field-select" id="editRoleSelect" required>
                        <option value="" disabled {{ !$roleActual ? 'selected' : '' }}>Selecciona un rol</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" {{ $roleActual === $r->name ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-top:.75rem;" id="clientesMultiBlock">
                    <label class="field-label">Clientes (asignación)</label>
                    <select name="clientes[]" class="field-select" id="editClientesSelect" multiple size="8">
                        @foreach($clientesAll as $c)
                            <option value="{{ $c->id }}"
                                {{ $clientesAsignadosIds->contains((int)$c->id) ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="help-text">Para rol "user" debes seleccionar al menos 1 cliente. Para "superadmin" se eliminarán.</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelUserEditModal">Cancelar</button>
                <button type="submit" class="btn-primary" id="btnSaveUserEdit">
                    💾 Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
{{-- MODAL CASIGNAR CLIENTE --}}
    <div class="modal-backdrop" id="clientesModal">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="clientesModalTitle">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="clientesModalTitle">Asignar cliente</div>
                <div class="card-subtitle">Selecciona un cliente disponible para asignarlo al usuario.</div>
            </div>
            <button type="button" class="modal-close" id="btnCloseClientesModal">Cerrar</button>
        </div>

        <form method="POST" action="{{ route('users.clientes.asignar', $user) }}">
            @csrf

            <div class="modal-body">
                <label class="field-label">Cliente</label>
                <select name="cliente_id" class="field-select" required>
                    <option value="" selected disabled>Selecciona un cliente</option>
                    @forelse($clientesDisponibles as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @empty
                        <option value="" disabled>No hay clientes disponibles para asignar</option>
                    @endforelse
                </select>
                <div class="help-text">Solo se muestran clientes que aún no están asignados a este usuario.</div>

                <div style="margin-top: 1rem; display:grid; grid-template-columns: 1fr 1fr; gap: .75rem;">
                    <div>
                        <label class="field-label">Rol (pivot)</label>
                        <input name="role" class="field-input" placeholder="company_admin" value="company_admin">
                    </div>
                    <div>
                        <label class="field-label">Status (pivot)</label>
                        <input name="status" class="field-input" placeholder="active" value="active">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelClientesModal">Cancelar</button>
                <button type="submit" class="btn-primary" {{ $clientesDisponibles->isEmpty() ? 'disabled' : '' }}>
                    ✅ Asignar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('clientesModal');
    const openBtn = document.getElementById('btnOpenClientesModal');
    const closeBtn = document.getElementById('btnCloseClientesModal');
    const cancelBtn = document.getElementById('btnCancelClientesModal');

    function openModal() { modal.classList.add('show'); }
    function closeModal() { modal.classList.remove('show'); }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Cerrar al dar click fuera de la tarjeta
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // ESC para cerrar
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
})();
(function () {
    const modal = document.getElementById('userEditModal');
    const openBtn = document.getElementById('btnOpenUserEditModal');
    const closeBtn = document.getElementById('btnCloseUserEditModal');
    const cancelBtn = document.getElementById('btnCancelUserEditModal');

    const form = document.getElementById('formUserUpdate');
    const alertBox = document.getElementById('userEditAlert');
    const saveBtn = document.getElementById('btnSaveUserEdit');

    const roleSelect = document.getElementById('editRoleSelect');
    const clientesBlock = document.getElementById('clientesMultiBlock');

    function openModal() { modal.classList.add('show'); }
    function closeModal() {
        modal.classList.remove('show');
        hideAlert();
    }

    function showAlert(type, message) {
        alertBox.style.display = 'block';
        alertBox.style.padding = '.6rem .75rem';
        alertBox.style.borderRadius = '10px';
        alertBox.style.fontSize = '13px';

        if (type === 'success') {
            alertBox.style.background = '#ECFDF5';
            alertBox.style.color = '#065F46';
            alertBox.style.border = '1px solid #A7F3D0';
        } else {
            alertBox.style.background = '#FEF2F2';
            alertBox.style.color = '#991B1B';
            alertBox.style.border = '1px solid #FECACA';
        }
        alertBox.textContent = message;
    }
    function hideAlert() {
        alertBox.style.display = 'none';
        alertBox.textContent = '';
    }

    function syncClientesVisibility() {
        const role = roleSelect.value;
        // Si superadmin, ocultamos selección (porque en backend se detacha)
        if (role === 'superadmin') {
            clientesBlock.style.display = 'none';
        } else {
            clientesBlock.style.display = 'block';
        }
    }

    if (openBtn) openBtn.addEventListener('click', function () {
        syncClientesVisibility();
        openModal();
    });
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

    roleSelect.addEventListener('change', syncClientesVisibility);

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        hideAlert();

        saveBtn.disabled = true;

        try {
            const url = form.getAttribute('action');
            const formData = new FormData(form);

            // Laravel espera PUT/PATCH: ya lo cubres con @method('PUT') en FormData
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await res.json().catch(() => null);

            if (!res.ok) {
                // 422 validation, 403, 500
                if (data && data.message) {
                    // Si trae errors, mostrarlos en una sola línea breve
                    if (data.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        const firstMsg = data.errors[firstKey]?.[0];
                        showAlert('error', firstMsg || data.message);
                    } else {
                        showAlert('error', data.message);
                    }
                } else {
                    showAlert('error', 'No se pudo actualizar el usuario.');
                }
                saveBtn.disabled = false;
                return;
            }

            showAlert('success', data?.message || 'Usuario actualizado exitosamente.');

            // Refrescar vista para ver card actualizado + listas
            setTimeout(() => window.location.reload(), 650);

        } catch (err) {
            showAlert('error', 'Error de red al actualizar el usuario.');
            saveBtn.disabled = false;
        }
    });
})();
(function () {
    const modal = document.getElementById('resetPassModal');
    const openBtn = document.getElementById('btnOpenResetPassModal');
    const closeBtn = document.getElementById('btnCloseResetPassModal');
    const cancelBtn = document.getElementById('btnCancelResetPassModal');

    const confirmInput = document.getElementById('resetConfirmInput');
    const doBtn = document.getElementById('btnDoResetPass');

    const alertBox = document.getElementById('resetPassAlert');

    const tempBox = document.getElementById('tempPasswordBox');
    const tempInput = document.getElementById('tempPasswordInput');
    const copyBtn = document.getElementById('btnCopyTempPass');

    function openModal() {
        modal.classList.add('show');
        hideAlert();
        tempBox.style.display = 'none';
        tempInput.value = '';
        confirmInput.value = '';
        doBtn.disabled = false;
    }

    function closeModal() {
        modal.classList.remove('show');
        hideAlert();
    }

    function showAlert(type, message) {
        alertBox.style.display = 'block';
        alertBox.style.padding = '.6rem .75rem';
        alertBox.style.borderRadius = '10px';
        alertBox.style.fontSize = '13px';

        if (type === 'success') {
            alertBox.style.background = '#ECFDF5';
            alertBox.style.color = '#065F46';
            alertBox.style.border = '1px solid #A7F3D0';
        } else {
            alertBox.style.background = '#FEF2F2';
            alertBox.style.color = '#991B1B';
            alertBox.style.border = '1px solid #FECACA';
        }
        alertBox.textContent = message;
    }

    function hideAlert() {
        alertBox.style.display = 'none';
        alertBox.textContent = '';
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

    doBtn.addEventListener('click', async function () {
        hideAlert();

        if ((confirmInput.value || '').trim().toUpperCase() !== 'YES') {
            showAlert('error', 'Confirmación inválida. Escribe YES para continuar.');
            return;
        }

        doBtn.disabled = true;

        try {
            const res = await fetch(@json(route('users.password.reset', $user)), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
                body: JSON.stringify({ confirm: 'YES' })
            });

            const data = await res.json().catch(() => null);

            if (!res.ok) {
                showAlert('error', data?.message || 'No se pudo resetear la contraseña.');
                doBtn.disabled = false;
                return;
            }

            showAlert('success', data?.message || 'Contraseña reseteada.');
            if (data?.temp_password) {
                tempBox.style.display = 'block';
                tempInput.value = data.temp_password;
            }
        } catch (e) {
            showAlert('error', 'Error de red al resetear la contraseña.');
            doBtn.disabled = false;
        }
    });

    copyBtn.addEventListener('click', async function () {
        const val = tempInput.value || '';
        if (!val) return;

        try {
            await navigator.clipboard.writeText(val);
            showAlert('success', 'Contraseña copiada al portapapeles.');
        } catch (e) {
            showAlert('error', 'No se pudo copiar. Copia manualmente.');
        }
    });
})();
</script>
</x-app-layout>

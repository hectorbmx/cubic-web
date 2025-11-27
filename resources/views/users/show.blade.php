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

            </div>
        </div>
    </div>
</x-app-layout>

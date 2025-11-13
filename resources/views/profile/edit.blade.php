<x-app-layout>
    {{-- === ESTILOS LOCALES === --}}
    <style>
        .profile-page {
            font-family: 'Inter','Segoe UI',system-ui,-apple-system,sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Hero compacto */
        .page-hero {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            color: #fff;
            padding: 1.25rem 1.5rem;
            border-radius: 16px;
            margin: 1rem 0 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        .page-hero h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            display: flex; gap: .5rem; align-items: center;
        }
        .page-hero p { margin: .35rem 0 0; opacity: .9; font-size: 14px; }

        /* CARD centrada y contenida */
        .profile-card {
            max-width: 720px;
            margin: 0 auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            background: #0f1b28;           /* azul muy oscuro */
            color: #fff;
            border: 1px solid rgba(255,255,255,.06);
        }
        .profile-card__head {
            padding: 1rem 1.25rem;
            background: #132538;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; justify-content: space-between; align-items: center;
        }
        .profile-card__title { font-weight: 700; font-size: 16px; display: flex; gap:.5rem; align-items:center; }
        .profile-card__hint { font-size: 12px; color: #c8d3df; }

        .profile-card__body {
            padding: 1.25rem;
            background: linear-gradient(180deg, #0f1b28 0%, #132538 100%);
        }

        /* Inputs */
        .form-grid { display: grid; gap: 1rem; }
        .form-group label {
            display: block; margin-bottom: .35rem;
            font-size: 13px; color: #dfe8f1; font-weight: 600;
        }
        .input {
            width: 100%;
            background: #0b1622;
            color: #fff;
            border: 1.5px solid #21364a;
            border-radius: 10px;
            padding: .7rem .9rem;
            font-size: 14px;
            transition: all .2s ease;
        }
        .input:focus {
            outline: none;
            border-color: #FCC200;
            box-shadow: 0 0 0 3px rgba(252,194,0,.18);
        }
        .error { color: #ffb3b3; font-size: 12px; margin-top: .25rem; }

        /* Botón */
        .actions { display: flex; justify-content: flex-end; margin-top: .75rem; }
        .btn-primary {
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            color: #2c4a6b;
            padding: .7rem 1.25rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(252,194,0,.25);
            display: inline-flex; align-items: center; gap:.5rem;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(252,194,0,.32); }

        /* Card secundaria (password) */
        .white-card {
            max-width: 720px; margin: 1.25rem auto 0;
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,.07);
            border: 1px solid #eaeef3;
        }
        .white-card__head { background:#f3f6fa; padding: .9rem 1.25rem; border-bottom:1px solid #e6ebf1; font-weight:700; color:#1e3449; display:flex; gap:.5rem; align-items:center;}
        .white-card__body { padding: 1.25rem; }
    </style>

    {{-- === HEADER COMPACTO === --}}
    <x-slot name="header">
        <div class="page-hero">
            <h2>👤 Perfil de Usuario</h2>
            <p>Completa tu información personal para acceder a todas las funciones del sistema.</p>
        </div>
    </x-slot>

    <div class="profile-page">
        {{-- CARD PRINCIPAL (datos mínimos requeridos) --}}
        <div class="profile-card">
            <div class="profile-card__head">
                <div class="profile-card__title">✏️ Actualiza tu información</div>
                <div class="profile-card__hint">Los campos con * son obligatorios</div>
            </div>

            <div class="profile-card__body">
               <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-grid">

        <div class="form-group">
             <label for="avatar">Foto de perfil</label>

            <div style="display:flex; align-items:center; gap:1rem;">
                {{-- Vista previa --}}
                @if(auth()->user()->avatar_path)
                    <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}"
                         alt="Avatar" width="80" height="80"
                         style="border-radius:50%; object-fit:cover; border:2px solid #FCC200;">
                @else
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                         alt="Default Avatar" width="80" height="80"
                         style="border-radius:50%; object-fit:cover; opacity:.8;">
                @endif

                {{-- Input de carga --}}
                <input type="file" name="avatar" id="avatar"
                       accept="image/*"
                       class="input" style="padding:.4rem; background:#fff; color:#000;">
            </div>

            @error('avatar')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
            <label for="name">Usuario *</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name ?? auth()->user()->name) }}"
                   class="input" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="first_name">Nombre *</label>
            <input id="first_name" name="first_name" type="text"
                   value="{{ old('first_name', $user->first_name ?? auth()->user()->first_name) }}"
                   class="input" required>
            @error('first_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="last_name">Primer Apellido *</label>
            <input id="last_name" name="last_name" type="text"
                   value="{{ old('last_name', $user->last_name ?? auth()->user()->last_name) }}"
                   class="input" required>
            @error('last_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="phone">Teléfono *</label>
            <input id="phone" name="phone" type="text"
                   value="{{ old('phone', $user->phone ?? auth()->user()->phone) }}"
                   class="input">
            @error('phone') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="position">Puesto en la empresa</label>
            <input id="position" name="position" type="text"
                   value="{{ old('position', $user->position ?? auth()->user()->position) }}"
                   class="input">
            @error('position') <div class="error">{{ $message }}</div> @enderror
        </div>

    </div>

    <div class="actions">
        <button class="btn-primary" type="submit">💾 Guardar Cambios</button>
    </div>
</form>

            </div>
        </div>

        {{-- CARD SECUNDARIA: Cambiar contraseña (opcional, mantiene coherencia visual) --}}
        <div class="white-card">
            <div class="white-card__head">🔐 Cambiar contraseña</div>
            <div class="white-card__body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-app-layout>

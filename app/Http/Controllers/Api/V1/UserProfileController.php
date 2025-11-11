<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\UpdateMeRequest;


class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        // Si necesitas relaciones (clientePrincipal, obras, roles):
        // $user = $request->user()->load(['clientePrincipal', 'obras', 'roles']);
        $user = $request->user()->loadMissing(['clientePrincipal', 'obras', 'roles']);
        return new UserResource($user);
    }

    public function update(UpdateMeRequest $request)
    {
        $user = $request->user();

        DB::transaction(function () use ($user, $request) {
            // Solo campos permitidos por el FormRequest
            $user->fill($request->validated());
            $user->save();
        });

        // Regresamos el recurso actualizado
        return new UserResource($user->fresh()->loadMissing(['clientePrincipal', 'obras', 'roles']));
    }

    // Opcional: cambiar contraseña en endpoint separado
    // public function updatePassword(UpdatePasswordRequest $request) { ... }

    // Opcional: subir avatar (multipart/form-data)
    // public function updateAvatar(UpdateAvatarRequest $request) { ... }
}

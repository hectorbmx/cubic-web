<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'lastName'  => $this->last_name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'birthDate' => $this->birth_date,
            'photoUrl'  => $this->photo_url,

            // Si usas Spatie:
            'roles'     => $this->whenLoaded('roles', fn () => $this->roles->pluck('name')),

            // Relaciones útiles para el perfil:
            'clientePrincipal' => $this->whenLoaded('clientePrincipal', function () {
                return [
                    'id'   => $this->clientePrincipal->id,
                    'name' => $this->clientePrincipal->nombre ?? $this->clientePrincipal->name ?? null,
                ];
            }),

            // Si te sirve listar obras asignadas (resumen):
            'obras' => $this->whenLoaded('obras', function () {
                return $this->obras->map(fn ($obra) => [
                    'id'    => $obra->id,
                    'nombre'=> $obra->nombre ?? $obra->name ?? null,
                    'pivot' => [
                        'role' => $obra->pivot->role ?? null,
                    ],
                ]);
            }),

            // Campos de auditoría (si los quieres):
            // 'createdAt' => $this->created_at?->toISOString(),
            // 'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}

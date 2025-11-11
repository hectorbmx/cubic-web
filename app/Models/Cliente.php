<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'tax_id',
        'status',
        // otros campos...
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con obras
    public function obras()
    {
        return $this->hasMany(Obra::class, 'client_id');
    }

    // Relación con usuarios (miembros de la empresa) - muchos a muchos
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'cliente_user')
                    ->withPivot('role', 'status', 'invited_at', 'accepted_at', 'invited_by_user_id')
                    ->withTimestamps();
    }

    // Usuarios activos solamente
    public function usuariosActivos()
    {
        return $this->belongsToMany(User::class, 'cliente_user')
                    ->wherePivot('status', 'active')
                    ->withPivot('role', 'status', 'invited_at', 'accepted_at')
                    ->withTimestamps();
    }

    // Usuarios invitados (pendientes)
    public function usuariosInvitados()
    {
        return $this->belongsToMany(User::class, 'cliente_user')
                    ->wherePivot('status', 'invited')
                    ->withPivot('role', 'invited_at', 'invited_by_user_id')
                    ->withTimestamps();
    }

    // Administradores de la empresa
    public function administradores()
    {
        return $this->belongsToMany(User::class, 'cliente_user')
                    ->wherePivot('role', 'company_admin')
                    ->wherePivot('status', 'active')
                    ->withTimestamps();
    }

    // Contar obras activas
    public function obrasActivas()
    {
        return $this->obras()
                    ->whereIn('status', ['planning', 'in_progress']);
    }
    public function users()
    {
        // tabla pivot: cliente_user
        return $this->belongsToMany(User::class, 'cliente_user')
            ->withPivot(['role', 'status', 'invited_at', 'invited_by_user_id'])
            ->withTimestamps();
    }
    public function obrasCompletadas()
    {
    return $this->obras()
                ->where('status', 'completed');
    }
    
}
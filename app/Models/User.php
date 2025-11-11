<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
// use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,hasRoles, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'password',
        'position',
        'avatar_path',
        'status',
        'client_id',
        'invitation_token',
        'invitation_sent_at',
        'invitation_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'invitation_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'invitation_sent_at' => 'datetime',
        'invitation_accepted_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación con empresas (clientes) - muchos a muchos
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_user')
                    ->withPivot('role', 'status', 'invited_at', 'accepted_at', 'invited_by_user_id')
                    ->withTimestamps();
    }

    // Relación con obras - muchos a muchos
    // public function obras()
    // {
    //     return $this->belongsToMany(Obra::class, 'obra_user')
    //                 ->withPivot('role')
    //                 ->withTimestamps();
    // }
    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_user','user_id','obra_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Cliente principal (si existe)
    public function clientePrincipal()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }

    // Generar token de invitación
    public function generateInvitationToken()
    {
        $this->invitation_token = Str::random(64);
        $this->invitation_sent_at = now();
        $this->save();
        
        return $this->invitation_token;
    }

    // Verificar si el token es válido (60 minutos)
    public function isInvitationValid()
    {
        if (!$this->invitation_token || !$this->invitation_sent_at) {
            return false;
        }
        
        return $this->invitation_sent_at->diffInMinutes(now()) <= 60;
    }

    // Aceptar invitación
    public function acceptInvitation()
    {
        $this->invitation_accepted_at = now();
        $this->invitation_token = null;
        $this->save();
    }

    // Verificar si tiene acceso a una empresa
    public function hasAccessToCliente($clienteId)
    {
        return $this->clientes()
                    ->where('cliente_id', $clienteId)
                    ->wherePivot('status', 'active')
                    ->exists();
    }

    // Verificar si tiene acceso a una obra
    public function hasAccessToObra($obraId)
    {
        return $this->obras()->where('obra_id', $obraId)->exists();
    }

    // Obtener rol en una empresa
    public function getRoleInCliente($clienteId)
    {
        $membership = $this->clientes()
                          ->where('cliente_id', $clienteId)
                          ->first();
        
        return $membership ? $membership->pivot->role : null;
    }

    // Verificar si es admin de una empresa
    public function isCompanyAdmin($clienteId)
    {
        return $this->getRoleInCliente($clienteId) === 'company_admin';
    }

    // Verificar si es SuperAdmin
public function isSuperAdmin()
    {
        // Opción con Spatie
        return $this->hasRole('superadmin');
        
        // O mantener el email como fallback
        // return $this->hasRole('superadmin') || $this->email === 'hectorhaw@gmail.com';
    }

}
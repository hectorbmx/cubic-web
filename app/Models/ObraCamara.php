<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraCamara extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo
     */
    protected $table = 'obras_camaras';

    /**
     * Los atributos que son asignables en masa
     */
    protected $fillable = [
        'obra_id',
        'name',
        'url',
        'username',
        'password',
        'notes',
        'is_active',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los atributos que deben ser ocultos para arrays
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relación: Una cámara pertenece a una obra
     */
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    /**
     * Mutator: Encriptar password antes de guardar
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = encrypt($value);
        }
    }

    /**
     * Accessor: Desencriptar password
     */
    public function getPasswordDecryptedAttribute()
    {
        if (!empty($this->password)) {
            try {
                return decrypt($this->password);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Scope: Solo cámaras activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
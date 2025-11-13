<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo
     */
    protected $table = 'obras';

    /**
     * Los atributos que son asignables en masa
     */
    protected $fillable = [
        'client_id',
        'manager_user_id',
        'code',
        'name',
        'description',
        'status',
        'progress_pct',
        'start_date',
        'end_date',
        'address',
        'lat',
        'lng',
        'budget_amount',
        'currency',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget_amount' => 'decimal:2',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'progress_pct' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scopes para consultas comunes
     */
    public function scopePlanning($query)
    {
        return $query->where('status', 'planning');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Accessors y Mutators
     */
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'planning' => 'Planificación',
            'in_progress' => 'En Progreso',
            'paused' => 'Pausada',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getProgressFormattedAttribute()
    {
        return $this->progress_pct . '%';
    }

    /**
     * Relaciones
     */
    
    /**
     * Una obra pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }

    /**
     * Una obra tiene un usuario manager (responsable/supervisor)
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_user_id');
    }

    /**
     * Una obra tiene muchos detalles
     */
    public function detalles()
    {
        return $this->hasMany(ObraDetalle::class, 'obra_id');
    }

    /**
     * Una obra tiene muchos archivos media
     */
    public function media()
    {
        return $this->hasMany(ObraMedia::class, 'detalle_id');
    }

    /**
     * Obtener solo las imágenes de la obra
     */
    public function imagenes()
    {
        return $this->media()->where('type', 'image');
    }

    /**
     * Obtener solo los documentos de la obra
     */
    public function documentos()
    {
        return $this->media()->where('type', 'document');
    }

    /**
     * Métodos auxiliares
     */
    
    /**
     * Verifica si la obra está activa
     */
    public function isActive()
    {
        return in_array($this->status, ['planning', 'in_progress']);
    }

    /**
     * Verifica si la obra está completada
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Calcula los días restantes para finalizar
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $now = now();
        $endDate = $this->end_date;

        if ($now->gt($endDate)) {
            return 0; // Ya pasó la fecha
        }

        return $now->diffInDays($endDate);
    }

    /**
     * Una obra tiene muchas cámaras
     */
    public function camaras()
    {
        return $this->hasMany(ObraCamara::class, 'obra_id');
    }

    /**
     * Obtener solo cámaras activas
     */
    public function camarasActivas()
    {
        return $this->camaras()->where('is_active', true);
    }

    /**
     * Una obra tiene muchos informes semanales
     */
    public function informes()
    {
        return $this->hasMany(ObraInforme::class, 'obra_id');
    }

    //relacion con los planos*
    public function planos()
    {
    return $this->hasMany(ObraPlano::class);
    }
    // En App/Models/Obra.php, agregar:

 

    public function contratos()
    {
        return $this->hasMany(ObraContrato::class);
    }
    public function usuario()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    // En App/Models/Obra.php, agregar:

    public function fotos()
    {
        return $this->hasMany(ObraFoto::class);
    }
    // Agregar estas relaciones al modelo Obra existente

// Relación con usuarios asignados - muchos a muchos
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'obra_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Managers de la obra
    public function managers()
    {
        return $this->belongsToMany(User::class, 'obra_user')
                    ->wherePivot('role', 'manager')
                    ->withTimestamps();
    }

    // Residentes de la obra
    public function residentes()
    {
        return $this->belongsToMany(User::class, 'obra_user')
                    ->wherePivot('role', 'residente')
                    ->withTimestamps();
    }

    // Verificar si un usuario tiene acceso a esta obra
    public function tieneAccesoUsuario($userId)
    {
        return $this->usuarios()->where('user_id', $userId)->exists();
    }
    public function personas()
    {
        return $this->hasMany(ObraPersona::class);
    }
}
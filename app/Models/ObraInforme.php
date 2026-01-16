<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ObraInforme extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo
     */
    protected $table = 'obras_informes';

    /**
     * Los atributos que son asignables en masa
     */
    protected $fillable = [
        'obra_id',
        'created_by',
        'semana_numero',
        'fecha_inicio',
        'fecha_fin',
        'titulo',
        'resumen',
        'archivo_path',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'semana_numero' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Un informe pertenece a una obra
     */
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    /**
     * Relación: Un informe fue creado por un usuario
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessor: Obtener URL del archivo si existe
     */
    public function getArchivoUrlAttribute()
    {
        if ($this->archivo_path && Storage::exists($this->archivo_path)) {
            return Storage::url($this->archivo_path);
        }
        return null;
    }

    /**
     * Accessor: Verificar si tiene archivo
     */
    public function getTieneArchivoAttribute()
    {
        return !empty($this->archivo_path) && Storage::exists($this->archivo_path);
    }

    /**
     * Accessor: Rango de fechas formateado
     */
    public function getRangoFechasAttribute()
    {
        return $this->fecha_inicio->format('d/m/Y') . ' - ' . $this->fecha_fin->format('d/m/Y');
    }

    /**
     * Scope: Ordenar por semana descendente
     */
    public function scopeLatestWeek($query)
    {
        return $query->orderBy('semana_numero', 'desc');
    }

    /**
     * Scope: Filtrar por obra
     */
    public function scopeForObra($query, $obraId)
    {
        return $query->where('obra_id', $obraId);
    }

    /**
     * Eliminar archivo asociado al eliminar el informe
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($informe) {
            if ($informe->archivo_path && Storage::exists($informe->archivo_path)) {
                Storage::delete($informe->archivo_path);
            }
        });
    }
}
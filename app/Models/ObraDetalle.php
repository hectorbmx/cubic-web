<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraDetalle extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo
     */
    protected $table = 'obras_detalles';

    /**
     * Los atributos que son asignables en masa
     */
    protected $fillable = [
        'obra_id',
        'created_by',
        'type',
        'title',
        'body',
        'place_name',
        'lat',
        'lng',
        'progress_pct',
        'event_date',
        'cover_image',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     */
    protected $casts = [
        'obra_id' => 'integer',
        'created_by' => 'integer',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'progress_pct' => 'integer',
        'event_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relaciones
     */
    
    /**
     * Un detalle pertenece a una obra
     */
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }

    /**
     * Un detalle fue creado por un usuario
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Un detalle tiene muchos archivos media
     */
    public function media()
    {
        return $this->hasMany(ObraMedia::class, 'detalle_id');
    }

    /**
     * Obtener solo las imágenes del detalle
     */
    public function imagenes()
    {
        return $this->media()->where('type', 'image');
    }

    /**
     * Obtener solo los documentos del detalle
     */
    public function documentos()
    {
        return $this->media()->where('type', 'document');
    }

    /**
     * Obtener solo los videos del detalle
     */
    public function videos()
    {
        return $this->media()->where('type', 'video');
    }

    /**
     * Scopes
     */
    
    /**
     * Filtrar por tipo de detalle
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Ordenar por fecha de evento
     */
    public function scopeOrderByEventDate($query, $direction = 'desc')
    {
        return $query->orderBy('event_date', $direction);
    }

    /**
     * Métodos auxiliares
     */
    
    /**
     * Verifica si el detalle tiene coordenadas
     */
    public function hasLocation()
    {
        return !is_null($this->lat) && !is_null($this->lng);
    }

    /**
     * Obtiene el progreso formateado
     */
    public function getProgressFormattedAttribute()
    {
        return $this->progress_pct ? $this->progress_pct . '%' : 'N/A';
    }
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : null;
    }

}
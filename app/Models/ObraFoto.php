<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ObraFoto extends Model
{
    use HasFactory;

    protected $table = 'obras_fotos';

    protected $fillable = [
        'obra_id',
        'uploaded_by',
        'nombre_archivo',
        'ruta_archivo',
        'tamanio',
        'extension',
        'descripcion',
        'fecha_captura'
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'fecha_captura' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // public function getUrlAttribute()
    // {
    //     return Storage::url($this->ruta_archivo);
    // }
    public function getUrlAttribute()
{
    // Obtener solo el path relativo
    $path = str_replace('/storage', '', Storage::url($this->ruta_archivo));
    
    // Construir URL completa con APP_URL
    return config('app.url') . '/storage' . $path;
}

    public function deleteFile()
    {
        if (Storage::disk('public')->exists($this->ruta_archivo)) {
            return Storage::disk('public')->delete($this->ruta_archivo);
        }
        return false;
    }
    
}
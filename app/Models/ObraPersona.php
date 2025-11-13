<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObraPersona extends Model
{
    protected $table = 'obras_personas';

    protected $fillable = [
        'obra_id',
        'nombre_completo',
        'rol_empresa',
        'celular',
        'email',
        'fecha_asignacion',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }
}

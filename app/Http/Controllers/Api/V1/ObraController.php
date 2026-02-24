<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ObraController extends Controller
{
 public function index(Request $request)
{
    $user = $request->user();
    
    // Obtener clientes del usuario
    $clientesIds = $user->getClientesIds();
    
    // Query base filtrado por clientes del usuario
    $query = Obra::with(['cliente', 'manager'])
        ->whereIn('client_id', $clientesIds);

    // Filtrar por estado si se proporciona
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    // Filtrar por cliente específico si se proporciona
    if ($request->has('client_id')) {
        $query->where('client_id', $request->client_id);
    }

    $obras = $query->orderBy('created_at', 'desc')->get();

    return response()->json([
        'obras' => $obras->map(function ($obra) {
            return [
                'id' => $obra->id,
                'clienteId' => $obra->client_id,
                'clienteNombre' => $obra->cliente->name ?? 'Sin cliente',
                'nombre' => $obra->name,
                'codigo' => $obra->code,
                'descripcion' => $obra->description,
                'estado' => $obra->status,
                'progreso' => $obra->progress_pct ?? 0,
                'fechaInicio' => $obra->start_date?->format('Y-m-d'),
                'fechaFin' => $obra->end_date?->format('Y-m-d'),
                'direccion' => $obra->address,
                'responsable' => $obra->manager->name ?? 'Sin asignar',
            ];
        })
    ]);
}

    public function show(Obra $obra)
    {
        $obra->load([
            'cliente',
            'manager',
            'detalles',
            'camaras',
            'planos',
            'contratos',
            'fotos',
            'informes',
        ]);

        return response()->json([
            'obra' => [
                'id' => $obra->id,
                'codigo' => $obra->code,
                'nombre' => $obra->name,
                'descripcion' => $obra->description,
                'estado' => $obra->status,
                'progreso' => $obra->progress_pct ?? 0,
                'fechaInicio' => $obra->start_date?->format('Y-m-d'),
                'fechaFin' => $obra->end_date?->format('Y-m-d'),
                'direccion' => $obra->address,
                'lat' => $obra->lat,
                'lng' => $obra->lng,
                'presupuesto' => $obra->budget_amount,
                'moneda' => $obra->currency,
                'cover_image' => $obra->cover_image,
                
                // Cliente
                'cliente' => [
                    'id' => $obra->cliente->id ?? null,
                    'nombre' => $obra->cliente->name ?? 'Sin cliente',
                    'email' => $obra->cliente->email ?? null,
                ],
                
                // Responsable
                'responsable' => [
                    'id' => $obra->manager->id ?? null,
                    'nombre' => $obra->manager->name ?? 'Sin asignar',
                    'email' => $obra->manager->email ?? null,
                ],
                
                // Detalles/Historial
                'detalles' => $obra->detalles->map(function ($detalle) {
                    return [
                        'id' => $detalle->id,
                        'titulo' => $detalle->title ?? $detalle->nombre ?? '',
                        'descripcion' => $detalle->body ?? $detalle->body ?? '',
                        'progress' => $detalle->progress_pct ?? $detalle->progress_pct ?? '',
                        'fecha' => $detalle->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
                
                // Cámaras
                'camaras' => $obra->camaras->map(function ($camara) {
                    return [
                        'id' => $camara->id,
                        'nombre' => $camara->name ?? $camara->nombre ?? '',
                        'url' => $camara->url ?? $camara->stream_url ?? '',
                        
                        'activa' => $camara->is_active ?? true,
                    ];
                }),
                
                // Planos
                // 'planos' => $obra->planos->map(function ($plano) {
                //     return [
                //         'id' => $plano->id,
                //         'nombre' => $plano->name ?? $plano->nombre ?? '',
                //         'url' => $plano->file_path ?? $plano->url ?? '',
                //         'url' => $plano ? url(Storage::disk('public')->url($file_path)) : '',

                //         'fecha' => $plano->created_at->format('Y-m-d'),
                //     ];
                // }),
             'planos' => $obra->planos->map(function ($plano) {
    // 1. Obtenemos el path relativo (ej: "planos/10/archivo.pdf")
    // Usamos el campo que contenga solo el nombre/ruta del archivo, NO la url completa.
    $path = $plano->file_path ?? $plano->archivo_path ?? $plano->url ?? null;

    // Limpiamos el path por si acaso viene con la URL completa de la base de datos
    // Esto evita que se concatene doble si en la BD ya decía "https://..."
    if (str_contains($path, 'http')) {
        $path = str_replace(url(Storage::disk('public')->url('')), '', $path);
        $path = ltrim($path, '/');
    }

    return [
        'id'     => $plano->id,
        'nombre' => $plano->name ?? $plano->nombre ?? '',
        
        // OPCIÓN A: Si quieres que Laravel lo maneje (Recomendado)
        'url'    => $path ? asset('storage/' . $path) : '',
        
        // OPCIÓN B: Si necesitas FORZAR el "/public/" como pediste al inicio:
        // 'url' => $path ? "https://www.bmxmexico.com/cubic/public/storage/" . $path : '',

        'fecha'  => $plano->created_at ? $plano->created_at->format('Y-m-d') : '',
    ];
}),
                                    
                // Contratos
              'contratos' => $obra->contratos->map(function ($contrato) {
                        // Aquí asumo que file_path guarda algo como "contratos/7/xxx.pdf"
                        $path = $contrato->file_path ?: null;

                        // Si en tu DB ya tienes una url absoluta en $contrato->url, la respetamos
                        $absolute = $contrato->url && preg_match('/^https?:\/\//i', $contrato->url);

                        return [
                            'id' => $contrato->id,
                            'nombre' => $contrato->name ?? $contrato->nombre ?? '',
                            'file_path' => $path ?? '',

                            // ✅ Siempre una URL lista para abrir
                            'url' => $absolute
                                ? $contrato->url
                                : ($path ? url(Storage::disk('public')->url($path)) : ''),

                            'fecha' => optional($contrato->created_at)->format('Y-m-d') ?? '',
                        ];
                    }),
                                    
                // Fotos
                'fotos' => $obra->fotos->map(function ($foto) {
                     $baseUrl = config('app.url'); 
                    return [
                        'id' => $foto->id,
                        'url' => $foto->file_path ?? $foto->url ?? '',
                        'thumbnail' => $foto->thumbnail_path ?? $foto->url ?? '',
                        'descripcion' => $foto->description ?? $foto->descripcion ?? '',
                        'fecha' => $foto->created_at->format('Y-m-d'),
                    ];
                }),
                
                // Informes
               'informes' => $obra->informes->map(function ($informe) {
                        $path = $informe->archivo_path ?: null;

                        return [
                            'id' => $informe->id,
                            'semana' => $informe->semana_numero ?? '',
                            'fecha_inicio' => $informe->fecha_inicio?->format('Y-m-d') ?? '',
                            'fecha_fin' => $informe->fecha_fin?->format('Y-m-d') ?? '',
                            'titulo' => $informe->titulo ?? '',
                            'resumen' => $informe->resumen ?? '',
                            'archivo_path' => $path ?? '',

                            // ✅ URL pública absoluta (https://.../cubic/storage/...)
                            'url' => $path ? url(Storage::disk('public')->url($path)) : '',
                        ];
                    }),
                'personas' => $obra->personas->map(function ($persona){
                    return[
                        'id'     => $persona->id,
                        'nombre' => $persona->nombre_completo,
                        'rol'    => $persona->rol_empresa,
                        'celular'=> $persona->celular,
                        'email'  => $persona->email,

                    ];
                }),
            ]
        ]);
    }
 public function byCliente(Request $request, $clienteId)
    {
        $user = $request->user();
    
        // $isSuperAdmin = $user?->role === 'superadmin';
        $isSuperAdmin = $user && $user->hasRole('superadmin');

        $assignedClientIds = $user?->clientes()->pluck('clientes.id')->toArray() ?? [];

        if (!$isSuperAdmin && !in_array((int)$clienteId, $assignedClientIds, true)) {
            return response()->json([
                'message' => 'No autorizado para ver obras de este cliente.',
            ], 403);
        }

        $obras = Obra::query()
            ->where('client_id', $clienteId)
            ->latest('id')
            ->get();

        return response()->json([
            'data' => $obras,
        ], 200);
    }
}
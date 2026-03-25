<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ObraFotoController extends Controller
{

//limitamos a 6 fotos por carga y en total
public function store(Request $request, Obra $obra)
{
    try {
        $request->validate([
            'fotos'     => ['required', 'array', 'min:1', 'max:6'], // 👈 no más de 6 en el request
            'fotos.*'   => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'descripcion'   => ['nullable', 'string', 'max:500'],
            'fecha_captura' => ['nullable', 'date'],
        ]);

        $fotos = $request->file('fotos');

        // 👇 regla de negocio: máximo 6 fotos por obra (total)
        $existentes = $obra->fotos()->count();
        $nuevas = count($fotos);

        if (($existentes + $nuevas) > 6) {
            $disponibles = max(0, 6 - $existentes);

            return response()->json([
                'success' => false,
                'message' => "Solo se permiten 6 fotos por obra. Actualmente tienes {$existentes}. Puedes subir máximo {$disponibles} más.",
            ], 422);
        }

        $fotosGuardadas = [];
        $manager = new ImageManager(new Driver());
        foreach ($fotos as $foto) {
            $nombreOriginal = $foto->getClientOriginalName();
                $baseName = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME))
                    . '_' . time() . '_' . uniqid();

                $nombreUnico = $baseName . '.jpg';
                $ruta = 'fotos/' . $obra->id . '/' . $nombreUnico;

                // Leer, redimensionar y comprimir
                $img = $manager->read($foto->getPathname());

                // ✅ ancho máximo 1920 (mantiene proporción)
                $img->scaleDown(width: 1920);

                // ✅ guardar como JPG calidad 75
                $encoded = $img->toJpeg(quality: 75);

                // Guardar en disk public
                Storage::disk('public')->put($ruta, (string) $encoded);

                // Tamaño final real ya comprimido
                $tamanioFinal = Storage::disk('public')->size($ruta);

                // Forzamos extension a jpg (porque ya lo convertimos)
                $extension = 'jpg';


            $fotoModel = $obra->fotos()->create([
                'uploaded_by'     => auth()->id(),
                'nombre_archivo'  => $nombreOriginal,
                'ruta_archivo'    => $ruta,
                'tamanio'         => $tamanioFinal,
                'extension'       => $extension,
                'descripcion'     => $request->descripcion,
                'fecha_captura'   => $request->fecha_captura ?? now(),
            ]);

            $fotoModel->load('uploadedBy');
            $fotosGuardadas[] = $fotoModel;
        }

        return response()->json([
            'success' => true,
            'message' => count($fotosGuardadas) . ' foto(s) subida(s) exitosamente',
            'fotos' => $fotosGuardadas,
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Para que te regrese 422 limpio con errores de validación (útil en frontend)
        return response()->json([
            'success' => false,
            'message' => 'Validación fallida',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Throwable $e) {
    report($e);

    return response()->json([
        'success' => false,
        'message' => 'Error al subir las fotos',
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
    ], 500);
}
}

    // public function store(Request $request, Obra $obra)
    // {
    //     try {
    //         $request->validate([
    //             'fotos.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
    //             'descripcion' => 'nullable|string|max:500',
    //             'fecha_captura' => 'nullable|date'
    //         ]);

    //         $fotos = $request->file('fotos');
    //         $fotosGuardadas = [];

    //         foreach ($fotos as $foto) {
    //             $nombreOriginal = $foto->getClientOriginalName();
    //             $extension = $foto->getClientOriginalExtension();
    //             $nombreUnico = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) . '_' . time() . '_' . uniqid() . '.' . $extension;
                
    //             $ruta = $foto->storeAs('fotos/' . $obra->id, $nombreUnico, 'public');

    //             $fotoModel = $obra->fotos()->create([
    //                 'uploaded_by' => auth()->id(),
    //                 'nombre_archivo' => $nombreOriginal,
    //                 'ruta_archivo' => $ruta,
    //                 'tamanio' => $foto->getSize(),
    //                 'extension' => $extension,
    //                 'descripcion' => $request->descripcion,
    //                 'fecha_captura' => $request->fecha_captura ?? now()
    //             ]);

    //             $fotoModel->load('uploadedBy');
    //             $fotosGuardadas[] = $fotoModel;
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => count($fotosGuardadas) . ' foto(s) subida(s) exitosamente',
    //             'fotos' => $fotosGuardadas
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al subir las fotos: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function destroy(Obra $obra, ObraFoto $foto)
    {
        try {
            if ($foto->obra_id !== $obra->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Foto no encontrada'
                ], 404);
            }

            $foto->deleteFile();
            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la foto: ' . $e->getMessage()
            ], 500);
        }
    }
}
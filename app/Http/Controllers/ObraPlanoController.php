<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraPlano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ObraPlanoController extends Controller
{
    // public function store(Request $request, Obra $obra)
    // {
    //     try {
    //         $request->validate([
    //             'archivo' => 'required|file|mimes:pdf,dwg,dxf,jpg,jpeg,png|max:51200',
    //             'descripcion' => 'nullable|string|max:500'
    //         ]);

    //         $file = $request->file('archivo');
            
    //         $nombreOriginal = $file->getClientOriginalName();
    //         $extension = $file->getClientOriginalExtension();
    //         $nombreUnico = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
            
    //         $ruta = $file->storeAs('planos/' . $obra->id, $nombreUnico, 'public');

    //         $plano = $obra->planos()->create([
    //             'uploaded_by' => auth()->id(),
    //             'nombre_archivo' => $nombreOriginal,
    //             'ruta_archivo' => $ruta,
    //             'tamanio' => $file->getSize(),
    //             'extension' => $extension,
    //             'descripcion' => $request->descripcion
    //         ]);

    //         // Cargar la relación uploadedBy
    //         $plano->load('uploadedBy');

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Plano subido exitosamente',
    //             'plano' => $plano
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al subir el plano: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function store(Request $request, Obra $obra)
{
    try {

        // 0) ✅ Regla: solo 1 plano por obra (antes de validar/subir archivo)
        $yaTienePlano = $obra->planos()->exists(); // más eficiente que count()

        if ($yaTienePlano) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un plano para esta obra. Primero bórralo para poder subir uno nuevo.'
            ], 422);
        }

        
        $request->validate([
            'archivo'     => 'required|file|mimes:pdf,dwg,dxf,jpg,jpeg,png|max:51200',
            'descripcion' => 'nullable|string|max:500'
        ]);

        
        $file = $request->file('archivo');

        $nombreOriginal = $file->getClientOriginalName();
        $extension      = $file->getClientOriginalExtension();
        $nombreUnico    = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

        $ruta = $file->storeAs('planos/' . $obra->id, $nombreUnico, 'public');

        
        $plano = $obra->planos()->create([
            'uploaded_by'    => auth()->id(),
            'nombre_archivo' => $nombreOriginal,
            'ruta_archivo'   => $ruta,
            'tamanio'        => $file->getSize(),
            'extension'      => $extension,
            'descripcion'    => $request->descripcion
        ]);

        $plano->load('uploadedBy');

        return response()->json([
            'success' => true,
            'message' => 'Plano subido exitosamente',
            'plano'   => $plano
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Datos inválidos.',
            'errors'  => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al subir el plano: ' . $e->getMessage()
        ], 500);
    }
}


    public function destroy(Obra $obra, ObraPlano $plano)
    {
        try {
            if ($plano->obra_id !== $obra->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plano no encontrado'
                ], 404);
            }

            $plano->deleteFile();
            $plano->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plano eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plano: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(Obra $obra, ObraPlano $plano)
    {
        if ($plano->obra_id !== $obra->id) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($plano->ruta_archivo)) {
            return redirect()
                ->back()
                ->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download(
            $plano->ruta_archivo,
            $plano->nombre_archivo
        );
    }
}
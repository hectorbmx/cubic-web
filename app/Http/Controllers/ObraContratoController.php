<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ObraContratoController extends Controller
{
    public function store(Request $request, Obra $obra)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf,doc,docx|max:51200',
                'descripcion' => 'nullable|string|max:500'
            ]);

            $file = $request->file('archivo');
            
            $nombreOriginal = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nombreUnico = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
            
            $ruta = $file->storeAs('contratos/' . $obra->id, $nombreUnico, 'public');

            $contrato = $obra->contratos()->create([
                'uploaded_by' => auth()->id(),
                'nombre_archivo' => $nombreOriginal,
                'ruta_archivo' => $ruta,
                'tamanio' => $file->getSize(),
                'extension' => $extension,
                'descripcion' => $request->descripcion
            ]);

            // Cargar la relación uploadedBy
            $contrato->load('uploadedBy');

            if ($request->expectsJson() || $request->ajax()) {
    return response()->json([
        'success'  => true,
        'message'  => 'Contrato subido exitosamente',
        'contrato' => $contrato,
    ]);
}

// Flujo normal del panel web:
return redirect()
    ->route('works.show', $obra)   // o la ruta que uses para ver la obra
    ->with('success', 'Contrato subido exitosamente');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el contrato: ' . $e->getMessage()
            ], 500);
        }
    }
public function destroy(Obra $obra, ObraContrato $contrato)
{
    try {
        if ((int) $contrato->obra_id !== (int) $obra->id) {
            // Si es request AJAX/JSON, regresamos JSON; si no, redirect con error
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contrato no encontrado',
                ], 404);
            }

            return redirect()
                ->route('works.show', $obra->id)
                ->with('error', 'Contrato no encontrado');
        }

        $contrato->deleteFile();
        $contrato->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contrato eliminado exitosamente',
                'redirect' => route('works.show', $obra->id),
            ]);
        }

        return redirect()
            ->route('works.show', $obra->id)
            ->with('success', 'Contrato eliminado exitosamente');

    } catch (\Throwable $e) {

        report($e);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el contrato',
            ], 500);
        }

        return redirect()
            ->route('works.show', $obra->id)
            ->with('error', 'Error al eliminar el contrato');
    }
}


    public function download(Obra $obra, ObraContrato $contrato)
    {
        if ($contrato->obra_id !== $obra->id) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($contrato->ruta_archivo)) {
            return redirect()
                ->back()
                ->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download(
            $contrato->ruta_archivo,
            $contrato->nombre_archivo
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraInforme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ObraInformeController extends Controller
{
    public function store(Request $request, Obra $obra)
    {
        try {
            $request->validate([
                'archivo'        => 'required|file|mimes:pdf|max:51200', // 50MB
                'semana_numero'  => 'required|integer|min:1|max:53',
                'fecha_inicio'   => 'required|date',
                'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
                'titulo'         => 'required|string|max:255',
                'resumen'        => 'nullable|string|max:2000',
            ]);

            $file = $request->file('archivo');

            $nombreOriginal = $file->getClientOriginalName();
            $extension      = $file->getClientOriginalExtension(); // pdf

            // Nombre único basado en título
            $base = Str::slug(pathinfo($request->titulo, PATHINFO_FILENAME));
            $nombreUnico = 'semana_' . $request->semana_numero . '_' . ($base ?: 'informe') . '_' . time() . '.' . $extension;

            // Guardar en disk public (igual que contratos)
            $ruta = $file->storeAs('informes/' . $obra->id, $nombreUnico, 'public');

            $informe = $obra->informes()->create([
                'created_by'    => auth()->id(),
                'semana_numero' => (int) $request->semana_numero,
                'fecha_inicio'  => $request->fecha_inicio,
                'fecha_fin'     => $request->fecha_fin,
                'titulo'        => $request->titulo,
                'resumen'       => $request->resumen,
                'archivo_path'  => $ruta,
            ]);

            // Cargar relación creador (igual que contratos->uploadedBy)
            $informe->load('creador');

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Informe subido exitosamente',
                    'informe' => $informe,
                ]);
            }

            return redirect()
                ->route('works.show', $obra)
                ->with('success', 'Informe subido exitosamente');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el informe: ' . $e->getMessage()
            ], 500);
        }
    }

public function destroy(Obra $obra, ObraInforme $informe)
{
    try {
        if ((int) $informe->obra_id !== (int) $obra->id) {

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Informe no encontrado',
                ], 404);
            }

            return redirect()
                ->route('works.show', $obra->id)
                ->with('error', 'Informe no encontrado');
        }

        // Borrar archivo físico (defensivo)
        if (
            $informe->archivo_path &&
            \Storage::disk('public')->exists($informe->archivo_path)
        ) {
            \Storage::disk('public')->delete($informe->archivo_path);
        }

        $informe->delete();

        // 👉 AJAX / fetch
        if (request()->expectsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Informe eliminado exitosamente',
                'redirect' => route('works.show', $obra->id),
            ]);
        }

        // 👉 POST/DELETE normal (form submit)
        return redirect()
            ->route('works.show', $obra->id)
            ->with('success', 'Informe eliminado exitosamente');

    } catch (\Throwable $e) {

        report($e);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el informe',
            ], 500);
        }

        return redirect()
            ->route('works.show', $obra->id)
            ->with('error', 'Error al eliminar el informe');
    }
}


    public function download(Obra $obra, ObraInforme $informe)
    {
        if ((int) $informe->obra_id !== (int) $obra->id) {
            abort(404);
        }

        if (!$informe->archivo_path || !Storage::disk('public')->exists($informe->archivo_path)) {
            return redirect()
                ->back()
                ->with('error', 'El archivo no existe');
        }

        // nombre de descarga: título + semana
        $nombreDescarga = 'Informe_Semana_' . $informe->semana_numero . '_' .
            Str::slug($informe->titulo) . '.pdf';

        return Storage::disk('public')->download(
            $informe->archivo_path,
            $nombreDescarga
        );
    }
}

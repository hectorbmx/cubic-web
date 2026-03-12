<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObraDetalleController extends Controller
{
    /**
     * Almacenar un nuevo detalle de obra
     */
    public function store(Request $request, Obra $obra)
    {
        $request->validate([
            'type' => 'required|in:Earthworks,Foundations,Roofing,Enclosures,Installations,Finishes,Testing,Handover,progress',
            'title' => 'required|string|max:255',
            'progress_pct' => 'nullable|integer|min:0|max:100',
        ]);
        $detalle = ObraDetalle::create([
            'obra_id' => $obra->id,
            'created_by' => Auth::id(),
            'type' => $request->type,
            'title' => $request->title,
            // 'body' => $request->body,
            'progress_pct' => $request->progress_pct ?? 0,
        ]);

        // Si el tipo es 'progress', actualizar el progreso de la obra
        if ($request->type === 'progress' && $request->filled('progress_pct')) {
            $obra->update(['progress_pct' => $request->progress_pct]);
        }

        return redirect()->route('works.show', $obra)
            ->with('success', 'Detalle agregado exitosamente.');
    }

    /**
     * Eliminar un detalle
     */
    public function destroy(Obra $obra, ObraDetalle $detalle)
    {
        // Verificar que el detalle pertenece a la obra
        if ($detalle->obra_id !== $obra->id) {
            abort(404);
        }

        $detalle->delete();

        return redirect()->route('works.show', $obra)
            ->with('success', 'Detalle eliminado exitosamente.');
    }
}
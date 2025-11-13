<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraPersona;
use Illuminate\Http\Request;

class ObraPersonaController extends Controller
{
    public function store(Request $request, Obra $obra)
    {
        $data = $request->validate([
            'nombre_completo'  => 'required|string|max:255',
            'rol_empresa'      => 'nullable|string|max:255',
            'celular'          => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'fecha_asignacion' => 'nullable|date',
        ]);

        $data['obra_id'] = $obra->id;

        $persona = ObraPersona::create($data);

        // Respuesta JSON para Ajax
        return response()->json([
            'success' => true,
            'message' => 'Persona agregada correctamente',
            'persona' => $persona,
        ]);
    }

    public function destroy(Obra $obra, ObraPersona $persona)
    {
        if ($persona->obra_id !== $obra->id) {
            abort(404);
        }

        $persona->delete();

        return response()->json([
            'success' => true,
            'message' => 'Persona eliminada correctamente',
        ]);
    }
    public function update(Request $request, Obra $obra, ObraPersona $persona)
    {
        // Seguridad: que la persona pertenezca a esa obra
        if ($persona->obra_id !== $obra->id) {
            abort(404);
        }

        $data = $request->validate([
            'nombre_completo'  => 'required|string|max:255',
            'rol_empresa'      => 'nullable|string|max:255',
            'celular'          => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'fecha_asignacion' => 'nullable|date',
        ]);

        $persona->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Persona actualizada correctamente',
            'persona' => $persona->fresh(),
        ]);
    }

}

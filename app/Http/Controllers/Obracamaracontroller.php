<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\ObraCamara;
use Illuminate\Http\Request;

class ObraCamaraController extends Controller
{
    /**
     * Almacenar una nueva cámara
     */
    public function store(Request $request, Obra $obra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
    $urlInput = $request->url;
    $finalUrl = $urlInput;

        if (str_contains($urlInput, '<iframe')) {
        preg_match('/src="([^"]+)"/', $urlInput, $match);
        $finalUrl = $match[1] ?? $urlInput;
    } 
    // SI EL USUARIO PEGA EL SCRIPT DE PANOMAX: 
    // No podemos "convertir" el script a URL fácilmente, 
    // lo ideal es avisarle o usar una URL conocida de Panomax.
    elseif (str_contains($urlInput, '<script')) {
        // Opción A: Extraer el ID de instancia y construir la URL si es Panomax
        if (preg_match('/instance:\s*(\d+)/', $urlInput, $instanceMatch)) {
            // Nota: Verifica si esta estructura de URL funciona para todos tus casos de Panomax
            $finalUrl = "https://static.panomax.com/front/thumbnail/index.html?instance=" . $instanceMatch[1];
        }
    }
        ObraCamara::create([
            'obra_id' => $obra->id,
            'name' => $request->name,
            'url' => $finalUrl,
            'username' => $request->username,
            'password' => $request->password, // Se encripta automáticamente en el modelo
            'notes' => $request->notes,
            'is_active' => true,
        ]);

        return redirect()->route('works.show', $obra)
            ->with('success', 'Cámara agregada exitosamente.');
    }

    /**
     * Actualizar una cámara
     */
    public function update(Request $request, Obra $obra, ObraCamara $camara)
    {
        // Verificar que la cámara pertenece a la obra
        if ($camara->obra_id !== $obra->id) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'url', 'username', 'notes']);
        
        // Solo actualizar password si se proporciona uno nuevo
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $camara->update($data);

        return redirect()->route('works.show', $obra)
            ->with('success', 'Cámara actualizada exitosamente.');
    }

    /**
     * Eliminar una cámara
     */
    public function destroy(Obra $obra, ObraCamara $camara)
    {
        // Verificar que la cámara pertenece a la obra
        if ($camara->obra_id !== $obra->id) {
            abort(404);
        }

        $camara->delete();

        return redirect()->route('works.show', $obra)
            ->with('success', 'Cámara eliminada exitosamente.');
    }

    /**
     * Activar/Desactivar una cámara
     */
    public function toggleActive(Obra $obra, ObraCamara $camara)
    {
        if ($camara->obra_id !== $obra->id) {
            abort(404);
        }

        $camara->update(['is_active' => !$camara->is_active]);

        return redirect()->route('works.show', $obra)
            ->with('success', 'Estado de la cámara actualizado.');
    }
}
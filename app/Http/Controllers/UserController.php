<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra las obras asignadas a un usuario
     */
    // public function obras(User $user)
    // {
    //     // Cargar las obras del usuario con información adicional
    //     $obras = $user->obras()
    //         ->with('cliente')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(15);
        
    //     return view('usuarios.obras', compact('user', 'obras'));
    // }
    /**
 * Muestra las obras asignadas a un usuario
 */
public function obras(User $user)
{
    // Cargar las obras del usuario con información adicional
    $obras = $user->obras()
        ->with('cliente')
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    
    // Obtener TODAS las obras disponibles (de todos los clientes del usuario)
    $clientesIds = $user->clientes->pluck('id')->toArray();
    $obrasDisponibles = \App\Models\Obra::whereIn('client_id', $clientesIds)
        ->with('cliente')
        ->orderBy('name')
        ->get();
    
    return view('usuarios.obras', compact('user', 'obras', 'obrasDisponibles'));
}
    /**
 * Asigna obras a un usuario
 */
// public function asignarObras(Request $request, User $user)
// {
//     $request->validate([
//         'obras' => 'required|array|min:1',
//         'obras.*' => 'exists:obras,id',
//         'role' => 'required|in:company_admin,gestor,viewer',
//     ]);

//     try {
//         foreach ($request->obras as $obraId) {
//             // Verificar si ya está asignado
//             $exists = $user->obras()->where('obra_id', $obraId)->exists();
            
//             if (!$exists) {
//                 // Asignar usuario a la obra
//                 $user->obras()->attach($obraId, [
//                     'role' => $request->role,
//                     // 'status' => 'active',
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }
//         }

//         return redirect()
//             ->back()
//             ->with('success', 'Usuario asignado a las obras correctamente.');

//     } catch (\Exception $e) {
//         return redirect()
//             ->back()
//             ->with('error', 'Error al asignar obras: ' . $e->getMessage());
//     }
// }
public function asignarObras(Request $request, User $user)
{
    $request->validate([
        'obras'    => ['required','array','min:1'],
        'obras.*'  => ['exists:obras,id'],
        'role'     => ['required','in:manager,residente,viewer_obra'],
    ]);

    try {
        // 1) Insertar sin duplicar
        $payload = collect($request->obras)->mapWithKeys(function ($obraId) use ($request) {
            return [$obraId => ['role' => $request->role]];
        })->all();

        $user->obras()->syncWithoutDetaching($payload);

        // 2) (Opcional) Si ya estaba asignado, actualiza el rol
        foreach ($request->obras as $obraId) {
            $user->obras()->updateExistingPivot($obraId, ['role' => $request->role]);
        }

        return back()->with('success', 'Usuario asignado/actualizado en las obras correctamente.');
    } catch (\Throwable $e) {
        return back()->with('error', 'Error al asignar obras: '.$e->getMessage());
    }
}

}
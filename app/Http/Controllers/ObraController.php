<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    /**
     * Listado principal de obras (GET /works)
     */
    public function index(Request $request)
    {
        [$obras, $stats] = $this->buildObrasAndStats($request);

        return view('works.index', compact('obras', 'stats'));
    }

    /**
     * Búsqueda / filtros (GET /works/search)
     * Usa exactamente la misma lógica que index.
     */
    public function search(Request $request)
    {
        [$obras, $stats] = $this->buildObrasAndStats($request);

        return view('works.index', compact('obras', 'stats'));
    }

    /**
     * Construye el query de obras + estadísticas para el header
     */
    private function buildObrasAndStats(Request $request): array
    {
        // --- Query base para el listado ---
        $query = Obra::with(['cliente', 'manager']);

        // 🔍 Búsqueda por nombre, código o dirección
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        // 🎯 Filtro por estado
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // 🏢 Filtro por cliente
        if ($clientId = $request->input('client_id')) {
            $query->where('client_id', $clientId);
        }

        // Si quieres limitar por clientes asignados al usuario, podrías hacer algo tipo:
        // $clientesIds = $request->user()->getClientesIds();
        // $query->whereIn('client_id', $clientesIds);

        // Listado paginado (mantiene los filtros en la URL)
        $obras = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // --- Estadísticas del header ---
        // Aquí las hago globales; si quieres que respeten algún filtro,
        // se puede ajustar fácil.
        $statsBase = Obra::query();

        $stats = [
            'total'       => (clone $statsBase)->count(),
            'planning'    => (clone $statsBase)->where('status', 'planning')->count(),
            'in_progress' => (clone $statsBase)->where('status', 'in_progress')->count(),
            'paused'      => (clone $statsBase)->where('status', 'paused')->count(),
            'completed'   => (clone $statsBase)->where('status', 'completed')->count(),
            // si luego quieres mostrar 'cancelled', se puede agregar aquí
        ];

        return [$obras, $stats];
    }

    /**
     * Detalle de una obra (GET /works/{obra})
     * (esto ya lo tienes, pero lo pongo por si acaso)
     */
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

        return view('works.show', compact('obra'));
    }
}

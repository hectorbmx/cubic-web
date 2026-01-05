<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Cliente; // 👈 si tu modelo se llama distinto, cámbialo
use App\Models\User;
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
     * Mostrar formulario para crear una nueva obra (GET /works/create)
     */
public function create(Request $request)
{
    $user = $request->user();

    // Clientes visibles para este usuario
    $clientesQuery = Cliente::query();
    if ($user) {
        $clientesQuery = $clientesQuery->visibleFor($user);
    }
    $clientes = $clientesQuery->orderBy('name')->get();

    // Estados válidos
    $statuses = [
        'planning',
        'in_progress',
        'paused',
        'completed',
    ];
    $managers = User::role(['superadmin', 'admin', 'user'])
    ->orderBy('name')
    ->get();


    // Cliente actual (si vienes desde un cliente específico, luego podemos llenarlo)
    $cliente = null;

    // 👇 Responsables posibles (ajusta el filtro según tus roles)
    // Si usas Spatie:
    // $managers = User::role(['superadmin', 'company_admin'])->orderBy('name')->get();
    $managers = User::orderBy('name')->get();

    return view('works.create', compact('clientes', 'statuses', 'cliente', 'managers'));
}



    /**
     * Guardar una nueva obra en BD (POST /works)
     */
     public function store(Request $request)
    {
        // Ajusta estas reglas a los campos reales de tu tabla 'obras'
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'nullable|string|max:100',
            'address'   => 'nullable|string|max:500',
            'client_id' => 'required|exists:clientes,id',
            'status'    => 'required|in:planning,in_progress,paused,completed',
            'start_date'=> 'nullable|date',
            'end_date'  => 'nullable|date|after_or_equal:start_date',
        ]);

        // Si tu tabla tiene manager_id y quieres que sea el usuario logueado:
        if ($request->user()) {
            $validated['manager_id'] = $request->user()->id;
        }

        $obra = Obra::create($validated);

        return redirect()
            ->route('works.show', $obra)
            ->with('success', 'Obra creada correctamente.');
    }

    /**
     * Búsqueda / filtros (GET /works/search)
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

        $obras = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $statsBase = Obra::query();

        $stats = [
            'total'       => (clone $statsBase)->count(),
            'planning'    => (clone $statsBase)->where('status', 'planning')->count(),
            'in_progress' => (clone $statsBase)->where('status', 'in_progress')->count(),
            'paused'      => (clone $statsBase)->where('status', 'paused')->count(),
            'completed'   => (clone $statsBase)->where('status', 'completed')->count(),
        ];

        return [$obras, $stats];
    }

    /**
     * Detalle de una obra (GET /works/{obra})
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

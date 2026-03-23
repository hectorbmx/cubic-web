<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Cliente; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObraController extends Controller
{
    /**
     * Listado principal de obras (GET /works)
     */
    public function index(Request $request)
{
  
    $user = auth()->user();

    // Base query
    $query = Obra::query()
        ->with(['cliente']); // ajusta relaciones que uses en la vista

    // Si NO es admin/superadmin, filtrar por asignación
    if (!$user->hasAnyRole(['superadmin', 'admin'])) {
        $query->whereHas('usuarios', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }

    // Si tu buildObrasAndStats arma filtros/orden/paginación,
    // pásale $query o replica su lógica aquí.
    // Ejemplo simple:
    $obras = $query->orderByDesc('id')->paginate(10);

    // Stats: si ya tienes método, lo ideal es que use el mismo query filtrado.
    // Por ahora, ejemplo mínimo:
    $stats = [
        'total' => (clone $query)->count(),
        // agrega los que uses (planificacion, en_progreso, etc.)
    ];
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

    public function edit(Obra $obra)
    {
        // Cargar únicamente relaciones que EXISTEN en el modelo
        // (No incluyas 'Obra' porque no es relación)
        $obra->load([
            'cliente',
            'manager',
            // agrega solo si existen:
            // 'detalles',
            // 'camaras',
            // 'planos',
            // 'contratos',
            // 'fotos',
            // 'informes',
        ]);

        // Tu Blade necesita estos dos arreglos para los selects
        $clientes = Cliente::query()
            ->orderBy('name')
            ->get();

        $managers = User::query()
            ->orderBy('name')
            ->get();

        return view('works.edit', compact('obra', 'clientes', 'managers'));
    }
public function update(Request $request, Obra $obra)
{
//     dd([
//     'content_type' => $request->header('content-type'),
//     'hasFile'      => $request->hasFile('cover_image'),
//     'file'         => $request->file('cover_image'),
//     'all'          => $request->all(),
//     'files'        => $request->allFiles(),
// ]);

    $data = $request->validate([
        'client_id'         => ['required', 'integer', 'exists:clientes,id'],
        'manager_user_id'   => ['required', 'integer', 'exists:users,id'],
        'code'              => ['required', 'string', 'max:50'],
        'name'              => ['required', 'string', 'max:255'],
        'description'       => ['nullable', 'string'],
        'status'            => ['required', 'in:planning,in_progress,paused,completed,cancelled'],
        'progress_pct'      => ['required', 'integer', 'min:0', 'max:100'],
        'start_date'        => ['nullable', 'date'],
        'end_date'          => ['nullable', 'date', 'after_or_equal:start_date'],
        'address'           => ['nullable', 'string', 'max:255'],
        'lat'               => ['nullable', 'numeric', 'between:-90,90'],
        'lng'               => ['nullable', 'numeric', 'between:-180,180'],
        'budget_amount'     => ['nullable', 'numeric', 'min:0'],
        'currency'          => ['nullable', 'in:MXN,USD,EUR'],
        'cover_image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

    ]);
     // =========================
    // 📸 PROCESAR IMAGEN
    // =========================
    if ($request->hasFile('cover_image')) {

        // Eliminar imagen anterior si existe
        if ($obra->cover_image && Storage::disk('public')->exists($obra->cover_image)) {
            Storage::disk('public')->delete($obra->cover_image);
        }

        // Guardar nueva imagen
        $path = $request->file('cover_image')->store(
            'obras/' . $obra->id . '/cover',
            'public'
        );
    //      dd([
    //     'stored_path' => $path,
    //     'exists_public' => Storage::disk('public')->exists($path),
    //     'public_root' => Storage::disk('public')->path(''),
    // ]);

        $data['cover_image'] = $path;
    }

    // =========================
    // 💾 UPDATE OBRA
    // =========================


    $obra->update($data);

    return redirect()
        ->route('works.show', $obra)
        ->with('success', 'Obra actualizada correctamente.');
}
    /**
     * Construye el query de obras + estadísticas para el header
     */
private function buildObrasAndStats(Request $request): array
{
    $user = auth()->user();

    // --- Query base para el listado ---
    $query = Obra::with(['cliente', 'manager']);

    // ✅ Restricción por usuario asignado (solo para NO admin/superadmin)
    if (!$user->hasAnyRole(['admin', 'superadmin'])) {
        $query->whereHas('usuarios', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }

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

    // --- Stats base (deben respetar la misma restricción por usuario) ---
    $statsBase = Obra::query();

    if (!$user->hasAnyRole(['admin', 'superadmin'])) {
        $statsBase->whereHas('usuarios', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }

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
            'informes.creador',
        ]);

        return view('works.show', compact('obra'));
    }

public function destroy(Obra $obra)
{
    // 1. (Opcional) Eliminar archivos asociados
    // Si tu obra tiene una imagen en el storage, deberías borrarla aquí.

    // 2. Ejecutar la eliminación en la BD
    $obra->delete();

    // 3. Redireccionar al usuario con un mensaje de éxito
    return redirect()->route('works.index')
                     ->with('success', 'La obra ha sido eliminada correctamente.');
}
}

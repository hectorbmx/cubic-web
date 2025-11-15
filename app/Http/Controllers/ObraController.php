<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Cliente;
use App\Models\User;
use App\Models\ObraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ObraController extends Controller
{
    /**
     * Muestra la lista de todas las obras
     * Vista: resources/views/works/index.blade.php
     */
public function index()
{
    $user = auth()->user();
    
    // Query base filtrado por cliente
    $query = Obra::query();
    
    if (!$user->isSuperAdmin()) {
        $clientesIds = $user->getClientesIds();
        $query->whereIn('client_id', $clientesIds);
    }
    
    // Estadísticas para las tarjetas
    $stats = [
        'total' => (clone $query)->count(),
        'planning' => (clone $query)->where('status', 'planning')->count(),
        'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
        'paused' => (clone $query)->where('status', 'paused')->count(),
        'completed' => (clone $query)->where('status', 'completed')->count(),
    ];
    
    // Listado de obras con paginación
    $obras = (clone $query)->with('cliente')->latest()->paginate(15);
    
    return view('works.index', compact('obras', 'stats'));
}

    /**
     * Muestra el formulario para crear una nueva obra
     * Vista: resources/views/works/create.blade.php
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Obtener cliente si viene de URL
       $cliente = null;
if ($request->filled('client_id')) {
    $cliente = Cliente::find($request->client_id);

    if ($cliente && !$user->hasRole('superadmin')) {
        $tieneAcceso = $cliente->users()
            ->where('users.id', $user->id)
            ->exists();

        if (!$tieneAcceso) {
            abort(403, 'No tienes acceso a este cliente.');
        }
    }
}

        
        // Lista de clientes (solo los que el usuario puede ver)
        if ($user->hasRole('superadmin')) {
            $clientes = Cliente::orderBy('name')->get();
        } else {
            $clientes = $user->clientes()->orderBy('name')->get();
        }
        
        // Lista de managers (solo para superadmin)
        $managers = collect();
        if ($user->hasRole('superadmin')) {
            $managers = User::role(['admin', 'user', 'superadmin'])
                ->orderBy('name')
                ->get();
        }
        
        return view('works.create', compact('cliente', 'clientes', 'managers'));
    }

    /**
     * Almacena una nueva obra en la base de datos
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clientes,id',
            'manager_user_id' => 'nullable|exists:users,id',
            'code' => 'required|string|max:50|unique:obras,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,in_progress,paused,completed,cancelled',
            'progress_pct' => 'nullable|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'budget_amount' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ], [
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.exists' => 'El cliente seleccionado no existe.',
            'code.required' => 'El código de la obra es obligatorio.',
            'code.unique' => 'Este código de obra ya está en uso.',
            'name.required' => 'El nombre de la obra es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar que el usuario tenga acceso al cliente (si no es superadmin)
        if (!$user->hasRole('superadmin')) {
            $cliente = Cliente::find($request->client_id);
            if (!$cliente->hasUser($user->id)) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para crear obras para este cliente.')
                    ->withInput();
            }
        }

        // Si no se proporciona manager, asignar el usuario actual
        $data = $request->all();
        if (empty($data['manager_user_id'])) {
            $data['manager_user_id'] = $user->id;
        }

        // Si no se proporciona progress_pct, iniciar en 0
        if (!isset($data['progress_pct'])) {
            $data['progress_pct'] = 0;
        }

        // Crear la obra
        $obra = Obra::create($data);

        // Crear carpetas automáticas
        $this->crearCarpetasObra($obra);

        // Crear registro inicial en obras_detalles
        ObraDetalle::create([
            'obra_id' => $obra->id,
            'created_by' => $user->id,
            'type' => 'note',
            'title' => 'Obra creada',
            'body' => 'La obra ha sido registrada en el sistema.',
            'progress_pct' => 0,
        ]);

        return redirect()->route('works.show', $obra)
            ->with('success', 'Obra creada exitosamente.');
    }

    /**
     * Crear estructura de carpetas para la obra
     */
    private function crearCarpetasObra(Obra $obra)
    {
        $basePath = storage_path('app/obras/' . $obra->id . '-' . $obra->code);
        
        $carpetas = [
            'planos',
            'contratos',
            'fotos',
        ];

        foreach ($carpetas as $carpeta) {
            $path = $basePath . '/' . $carpeta;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }

        return true;
    }

    /**
     * Muestra los detalles de una obra específica
     * Vista: resources/views/works/show.blade.php
     */
    // public function show(Obra $obra)
    // {
    //     $obra->load(['cliente', 'manager', 'detalles.creador', 'detalles.media']);
        
    //     return view('works.show', compact('obra'));
    // }


    public function show(Obra $obra)
    {
        $obra->load([
            'cliente',
            'usuario',
            'planos' => function($query) {
                $query->with('uploadedBy')->orderBy('created_at', 'desc');
            },
            'contratos' => function($query) {
                $query->with('uploadedBy')->orderBy('created_at', 'desc');
            },
            'fotos' => function($query) {
                $query->with('uploadedBy')->orderBy('fecha_captura', 'desc')->orderBy('created_at', 'desc');
            }
        ]);

        return view('works.show', compact('obra'));
    }

    /**
     * Muestra el formulario para editar una obra
     * Vista: resources/views/works/edit.blade.php
     */
    public function edit(Obra $obra)
    {
        $clientes = Cliente::orderBy('name')->get();
        $managers = User::orderBy('name')->get();
        
        return view('works.edit', compact('obra', 'clientes', 'managers'));
    }

    /**
     * Actualiza una obra específica en la base de datos
     */
    public function update(Request $request, Obra $obra)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clientes,id',
            'manager_user_id' => 'nullable|exists:users,id',
            'code' => 'required|string|max:50|unique:obras,code,' . $obra->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,in_progress,paused,completed,cancelled',
            'progress_pct' => 'nullable|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'budget_amount' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ], [
            'client_id.required' => 'El cliente es obligatorio.',
            'client_id.exists' => 'El cliente seleccionado no existe.',
            'code.required' => 'El código de la obra es obligatorio.',
            'code.unique' => 'Este código de obra ya está en uso.',
            'name.required' => 'El nombre de la obra es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $obra->update($request->all());

        return redirect()->route('works.show', $obra)
            ->with('success', 'Obra actualizada exitosamente.');
    }

    /**
     * Elimina una obra de la base de datos
     */
    public function destroy(Obra $obra)
    {
        try {
            $obraName = $obra->name;
            $obra->delete();

            return redirect()->route('works.index')
                ->with('success', "La obra '{$obraName}' fue eliminada exitosamente.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se pudo eliminar la obra. Puede tener registros relacionados.');
        }
    }

    /**
     * Métodos adicionales útiles
     */

    /**
     * Busca obras según criterios
     */
    public function search(Request $request)
    {
        $query = Obra::with(['cliente', 'manager']);

        // Buscar por nombre o código
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%")
                  ->orWhere('address', 'like', "%{$searchTerm}%");
            });
        }

        // Filtrar por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por cliente
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filtrar por manager
        if ($request->filled('manager_user_id')) {
            $query->where('manager_user_id', $request->manager_user_id);
        }

        // Filtrar por rango de fechas
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $obras = $query->latest()->paginate(15)->withQueryString();
        
        return view('works.index', compact('obras'));
    }

    /**
     * Cambia el estado de una obra
     */
    public function cambiarEstado(Request $request, Obra $obra)
    {
        $request->validate([
            'status' => 'required|in:planning,in_progress,paused,completed,cancelled'
        ]);

        $oldStatus = $obra->status;
        $obra->update(['status' => $request->status]);

        // Si se completa la obra, actualizar progreso al 100%
        if ($request->status === 'completed') {
            $obra->update(['progress_pct' => 100]);
        }

        return redirect()->back()
            ->with('success', 'Estado de la obra actualizado correctamente.');
    }

    /**
     * Actualiza el progreso de una obra
     */
    public function updateProgress(Request $request, Obra $obra)
    {
        $request->validate([
            'progress_pct' => 'required|integer|min:0|max:100'
        ]);

        $obra->update(['progress_pct' => $request->progress_pct]);

        // Si el progreso llega al 100%, actualizar estado a completado
        if ($request->progress_pct == 100 && $obra->status !== 'completed') {
            $obra->update(['status' => 'completed']);
        }

        return redirect()->back()
            ->with('success', 'Progreso actualizado correctamente.');
    }

    /**
     * Obtiene obras por estado (para uso en API o AJAX)
     */
    public function byStatus($status)
    {
        $obras = Obra::with(['cliente', 'manager'])
            ->where('status', $status)
            ->latest()
            ->get();

        return response()->json($obras);
    }

    /**
     * Dashboard con estadísticas de obras
     */
    public function dashboard()
    {
        $user = auth()->user();

        $query = Obra::query();

        if (!$user->isSuperAdmin()) {
        $clientesIds = $user->getClientesIds();
        $query->whereIn('client_id', $clientesIds);
    }

        $stats = [
        'total' => (clone $query)->count(),
        'planning' => (clone $query)->planning()->count(),
        'in_progress' => (clone $query)->inProgress()->count(),
        'paused' => (clone $query)->paused()->count(),
        'completed' => (clone $query)->completed()->count(),
        'cancelled' => (clone $query)->cancelled()->count(),
    ];

       // Obras recientes filtradas
         $recentObras = (clone $query)
            ->with(['cliente', 'manager'])
            ->latest()
            ->take(10)
            ->get();

        $obrasProximasVencer = Obra::with(['cliente', 'manager'])
            ->whereNotNull('end_date')
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(30))
            ->whereIn('status', ['planning', 'in_progress'])
            ->orderBy('end_date')
            ->get();

        return view('works.dashboard', compact('stats', 'recentObras', 'obrasProximasVencer'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use App\Models\Cliente;

class DashboardController extends Controller
{
    //


    public function index()
{
    $user = auth()->user();
    
    // Obtener IDs de clientes del usuario
    $clientesIds = $user->getClientesIds();
    
    // === Totales - Filtrados por clientes del usuario ===
    $clientsTotal    = $user->isSuperAdmin() 
        ? Cliente::count()
        : Cliente::whereIn('id', $clientesIds)->count();
        
    $clientsActive   = $user->isSuperAdmin()
        ? Cliente::where('status', 'active')->count()
        : Cliente::whereIn('id', $clientesIds)->where('status', 'active')->count();

    $obrasTotal      = $user->isSuperAdmin()
        ? Obra::count()
        : Obra::whereIn('client_id', $clientesIds)->count();
        
    $obrasPlanning   = $user->isSuperAdmin()
        ? Obra::where('status', 'planning')->count()
        : Obra::whereIn('client_id', $clientesIds)->where('status', 'planning')->count();
        
    $obrasProgress   = $user->isSuperAdmin()
        ? Obra::where('status', 'in_progress')->count()
        : Obra::whereIn('client_id', $clientesIds)->where('status', 'in_progress')->count();
        
    $obrasPaused     = $user->isSuperAdmin()
        ? Obra::where('status', 'paused')->count()
        : Obra::whereIn('client_id', $clientesIds)->where('status', 'paused')->count();
        
    $obrasCompleted  = $user->isSuperAdmin()
        ? Obra::where('status', 'completed')->count()
        : Obra::whereIn('client_id', $clientesIds)->where('status', 'completed')->count();

    // === Listas recientes - Filtradas ===
    $latestObras = $user->isSuperAdmin()
        ? Obra::with('cliente')->latest()->take(5)->get()
        : Obra::with('cliente')->whereIn('client_id', $clientesIds)->latest()->take(5)->get();
        
    $latestClients = $user->isSuperAdmin()
        ? Cliente::withCount('obras')->latest()->take(5)->get()
        : Cliente::withCount('obras')->whereIn('id', $clientesIds)->latest()->take(5)->get();

    // === Gráficos - Filtrados ===
    $byStatus = $user->isSuperAdmin()
        ? Obra::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status')
        : Obra::whereIn('client_id', $clientesIds)->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

    $months = [];
    $monthCounts = [];
    for ($i = 5; $i >= 0; $i--) {
        $start = now()->startOfMonth()->subMonths($i);
        $end   = $start->copy()->endOfMonth();

        $months[] = $start->format('M Y');
        
        $monthCounts[] = $user->isSuperAdmin()
            ? Obra::whereBetween('created_at', [$start, $end])->count()
            : Obra::whereIn('client_id', $clientesIds)->whereBetween('created_at', [$start, $end])->count();
    }

    $upcomingObras = $user->isSuperAdmin()
        ? Obra::with('cliente')
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [now()->startOfDay(), now()->addDays(30)->endOfDay()])
            ->orderBy('end_date')
            ->take(6)
            ->get()
        : Obra::with('cliente')
            ->whereIn('client_id', $clientesIds)
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [now()->startOfDay(), now()->addDays(30)->endOfDay()])
            ->orderBy('end_date')
            ->take(6)
            ->get();

    $topClients = $user->isSuperAdmin()
        ? Cliente::withCount('obras')->orderBy('obras_count', 'desc')->take(5)->get()
        : Cliente::withCount('obras')->whereIn('id', $clientesIds)->orderBy('obras_count', 'desc')->take(5)->get();

    // === IMPORTANTE: pasa TODO al view ===
    return view('dashboard', [
        'clientsTotal'   => $clientsTotal,
        'clientsActive'  => $clientsActive,

        'obrasTotal'     => $obrasTotal,
        'obrasPlanning'  => $obrasPlanning,
        'obrasProgress'  => $obrasProgress,
        'obrasPaused'    => $obrasPaused,
        'obrasCompleted' => $obrasCompleted,

        'latestObras'    => $latestObras,
        'latestClients'  => $latestClients,

        'byStatus'       => $byStatus,
        'months'         => $months,
        'monthCounts'    => $monthCounts,
        'upcomingObras'  => $upcomingObras,
        'topClients'     => $topClients,
    ]);
}
}



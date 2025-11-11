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
        // === Totales (usa SIEMPRE estos nombres en el Blade) ===
        $clientsTotal    = Cliente::count();
        $clientsActive   = Cliente::where('status', 'active')->count();

        $obrasTotal      = Obra::count();
        $obrasPlanning   = Obra::where('status', 'planning')->count();
        $obrasProgress   = Obra::where('status', 'in_progress')->count();
        $obrasPaused     = Obra::where('status', 'paused')->count();
        $obrasCompleted  = Obra::where('status', 'completed')->count();

        // === Listas recientes ===
        $latestObras   = Obra::with('cliente')->latest()->take(5)->get();
        $latestClients = Cliente::withCount('obras')->latest()->take(5)->get();

        // === Parte baja: gráficos y tablas ===
        $byStatus = Obra::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status'); // ['planning'=>n, 'in_progress'=>n, ...]

        $months = [];
        $monthCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = now()->startOfMonth()->subMonths($i);
            $end   = $start->copy()->endOfMonth();

            $months[] = $start->format('M Y');
            $monthCounts[] = Obra::whereBetween('created_at', [$start, $end])->count();
        }

        $upcomingObras = Obra::with('cliente')
            ->whereNotNull('end_date')
            ->whereBetween('end_date', [now()->startOfDay(), now()->addDays(30)->endOfDay()])
            ->orderBy('end_date')
            ->take(6)
            ->get();

        $topClients = Cliente::withCount('obras')
            ->orderBy('obras_count', 'desc')
            ->take(5)
            ->get();

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



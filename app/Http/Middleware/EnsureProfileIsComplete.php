<?php

// app/Http/Middleware/EnsureProfileIsComplete.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    public function handle($request, \Closure $next)
{
    $user = auth()->user();
    if (!$user) return $next($request);

    // evita bucles: permite /profile
    if ($request->is('profile') || $request->is('profile/*') || $request->routeIs('profile*')) {
        return $next($request);
    }

    // ajusta a tus campos reales
    $complete = filled($user->name) && filled($user->phone) ;

    if (! $complete) {
        return redirect('/profile')->with('warning', 'Por favor, completa tu perfil.');
    }
    return $next($request);
}

}

<?php

namespace App\Http\Middleware;

use App\Services\MaintenanceService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Maintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        if (MaintenanceService::isActive()) {
            if (! Auth::check() && ! $request->routeIs('maintenance')) {
                return redirect()->route('maintenance');
            }
        } else {
            if ($request->routeIs('maintenance')) {
                return redirect()->route('home');
            }
        }

        return $next($request);

    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPortalEnabled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('parque.portal_enabled', true)) {
            if (Auth::check() && Auth::user()->isVaqueiro()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect()->route('login')->with('error', 'O portal do vaqueiro está temporariamente desativado.');
         }

        return $next($request);
    }
}

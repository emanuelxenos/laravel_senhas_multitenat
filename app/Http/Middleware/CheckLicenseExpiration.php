<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckLicenseExpiration
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expirationDate = config('parque.expires_at');

        if ($expirationDate) {
            try {
                $expire = Carbon::parse($expirationDate)->endOfDay();
                if (Carbon::now()->greaterThan($expire)) {
                    return response()->view('errors.license_expired', [], 403);
                }
            } catch (\Exception $e) {
                // Se a data for inválida ou mal formatada, prossegue por segurança
            }
        }

        return $next($request);
    }
}

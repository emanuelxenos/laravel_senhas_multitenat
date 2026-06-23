<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    /**
     * Redireciona para dashboard se autenticado, ou para login se não
     */
    public function index()
    {
        if (!app('tenant')->check()) {
            if (auth()->check()) {
                return redirect()->route('saas.dashboard');
            }
            return redirect()->route('login');
        }

        if (!config('parque.portal_enabled', true)) {
            if (auth()->check() && !auth()->user()->isVaqueiro()) {
                return redirect()->route('dashboard');
            }
            if (auth()->check() && auth()->user()->isVaqueiro()) {
                auth()->logout();
                session()->invalidate();
                session()->regenerateToken();
            }
            return redirect()->route('login');
        }

        if (auth()->check()) {
            if (auth()->user()->isVaqueiro()) {
                return redirect()->route('portal.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }
}

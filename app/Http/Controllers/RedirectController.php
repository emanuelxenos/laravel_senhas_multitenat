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
            return view('saas.landing');
        }

        if (auth()->check()) {
            if (auth()->user()->isVaqueiro()) {
                return redirect()->route('portal.dashboard');
            }
            return redirect()->route('dashboard');
        }

        // Se for um parque (tenant) e não estiver logado, exibe a página inicial do parque
        return view('welcome');
    }
}

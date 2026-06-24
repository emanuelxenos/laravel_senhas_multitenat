<?php

namespace App\Http\Controllers;

use App\Models\Parque;
use Illuminate\Http\Request;

class SaasAdminController extends Controller
{
    /**
     * Dashboard / Listagem de Parques
     */
    public function index()
    {
        // Apenas Admin global (sem parque_id) pode acessar
        if (auth()->user()->parque_id !== null) {
            abort(403, 'Acesso negado. Esta área é restrita ao Administrador Geral.');
        }

        $parques = Parque::orderBy('created_at', 'desc')->get();

        return view('saas.dashboard', compact('parques'));
    }

    /**
     * Cadastrar novo parque
     */
    public function store(Request $request)
    {
        if (auth()->user()->parque_id !== null) {
            abort(403);
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:parques,slug',
            'custom_domain' => 'nullable|string|max:255|unique:parques,custom_domain',
            'gateway_recipient_id' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,inativo',
            'expires_at' => 'nullable|date',
            'comissao_percentual' => 'nullable|numeric|min:0|max:100',
            'comissao_fixa' => 'nullable|numeric|min:0',
        ]);

        Parque::create($request->all());

        return redirect()->back()->with('success', 'Parque de Vaquejada cadastrado com sucesso!');
    }

    /**
     * Atualizar parque existente
     */
    public function update(Request $request, Parque $parque)
    {
        if (auth()->user()->parque_id !== null) {
            abort(403);
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:parques,slug,' . $parque->id,
            'custom_domain' => 'nullable|string|max:255|unique:parques,custom_domain,' . $parque->id,
            'gateway_recipient_id' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,inativo',
            'expires_at' => 'nullable|date',
            'comissao_percentual' => 'nullable|numeric|min:0|max:100',
            'comissao_fixa' => 'nullable|numeric|min:0',
        ]);

        $parque->update($request->all());

        return redirect()->back()->with('success', 'Parque atualizado com sucesso!');
    }

    /**
     * Excluir parque
     */
    public function destroy(Parque $parque)
    {
        if (auth()->user()->parque_id !== null) {
            abort(403);
        }

        $parque->delete();

        return redirect()->back()->with('success', 'Parque excluído com sucesso!');
    }
}

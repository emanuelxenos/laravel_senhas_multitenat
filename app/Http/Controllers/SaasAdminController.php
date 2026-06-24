<?php

namespace App\Http\Controllers;

use App\Models\Parque;
use App\Models\User;
use Illuminate\Http\Request;

class SaasAdminController extends Controller
{
    /**
     * Dashboard / Listagem de Parques
     */
    public function index(Request $request)
    {
        // Apenas Admin global (sem parque_id) pode acessar
        if (auth()->user()->parque_id !== null) {
            abort(403, 'Acesso negado. Esta área é restrita ao Administrador Geral.');
        }

        $search = $request->query('search');
        $query = Parque::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('custom_domain', 'like', "%{$search}%");
            });
        }

        $parques = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

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
            'portal_enabled' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
            'comissao_percentual' => 'nullable|numeric|min:0|max:100',
            'comissao_fixa' => 'nullable|numeric|min:0',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:6',
        ]);

        $data = $request->except(['admin_name', 'admin_email', 'admin_password']);
        $data['portal_enabled'] = $request->has('portal_enabled') ? (bool)$request->portal_enabled : true;

        // Criar o parque
        $parque = Parque::create($data);

        // Criar o usuário administrador do parque associado a ele
        User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => bcrypt($request->admin_password),
            'role' => 'admin',
            'parque_id' => $parque->id,
        ]);

        return redirect()->back()->with('success', 'Parque de Vaquejada e Administrador cadastrados com sucesso!');
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
            'portal_enabled' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
            'comissao_percentual' => 'nullable|numeric|min:0|max:100',
            'comissao_fixa' => 'nullable|numeric|min:0',
        ]);

        $data = $request->all();
        $data['portal_enabled'] = $request->has('portal_enabled') ? (bool)$request->portal_enabled : false;

        $parque->update($data);

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

    /**
     * Zerar dados do evento de um parque
     */
    public function reset(Request $request, Parque $parque)
    {
        if (auth()->user()->parque_id !== null) {
            abort(403);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        // Validar senha do Master Admin atual
        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Senha Master incorreta. Ação abortada.']);
        }

        // Limpar dados vinculados ao parque direto no banco para evitar restrições de escopos e eventos
        \Illuminate\Support\Facades\DB::transaction(function() use ($parque) {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Deletar corridas
            \Illuminate\Support\Facades\DB::table('corridas')->where('parque_id', $parque->id)->delete();
            
            // Deletar senhas
            \Illuminate\Support\Facades\DB::table('senhas')->where('parque_id', $parque->id)->delete();
            
            // Deletar inscrições
            \Illuminate\Support\Facades\DB::table('inscricoes')->where('parque_id', $parque->id)->delete();
            
            // Deletar competidores
            \Illuminate\Support\Facades\DB::table('competidores')->where('parque_id', $parque->id)->delete();
            
            // Deletar categorias
            \Illuminate\Support\Facades\DB::table('categorias')->where('parque_id', $parque->id)->delete();

            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });

        return redirect()->back()->with('success', 'Todos os dados do parque (categorias, inscrições, senhas e competidores) foram zerados com sucesso!');
    }
}

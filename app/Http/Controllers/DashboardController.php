<?php

namespace App\Http\Controllers;

use App\Models\Competidor;
use App\Models\Inscricao;
use App\Models\Senha;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class DashboardController extends Controller
{
    public function index()
    {
        if (!app('tenant')->check()) {
            return redirect()->route('saas.dashboard');
        }

        $totalCompetidores = Competidor::count();
        $totalInscricoes = Inscricao::count();
        $totalSenhas = Senha::count();
        
        // Faturamento bruto (total de inscrições pagas)
        $totalFaturamentoBruto = Inscricao::where('status_pagamento', 'pago')->sum('valor_total');

        // Buscar dados de taxas do parque ativo
        $tenant = app('tenant')->get();
        $comissaoPercentual = $tenant ? (float)$tenant->comissao_percentual : 0.0;
        $comissaoFixa = $tenant ? (float)$tenant->comissao_fixa : 0.0;

        // Buscar as inscrições pagas com contagem de senhas para deduzir a taxa fixa por senha e a taxa percentual
        $inscricoesPagas = Inscricao::where('status_pagamento', 'pago')
            ->withCount(['senhas' => function($q) {
                $q->where('status', '!=', 'cancelado');
            }])
            ->get();

        $totalComissaoDeducoes = 0.0;
        foreach ($inscricoesPagas as $insc) {
            $taxaPercentual = $insc->valor_total * ($comissaoPercentual / 100);
            $taxaFixaTotal = $insc->senhas_count * $comissaoFixa;
            $totalComissaoDeducoes += ($taxaPercentual + $taxaFixaTotal);
        }

        // Faturamento líquido
        $totalFaturamento = max(0.0, $totalFaturamentoBruto - $totalComissaoDeducoes);

        // Dados para gráfico: distribuição de pagamentos (por inscrição)
        $pagamentos = Inscricao::selectRaw('forma_pagamento, COUNT(*) as total')
            ->groupBy('forma_pagamento')
            ->pluck('total', 'forma_pagamento')
            ->toArray();

        // Dados para gráfico: senhas por categoria
        $senhasPorCategoria = Senha::join('inscricoes', 'senhas.inscricao_id', '=', 'inscricoes.id')
            ->join('categorias', 'inscricoes.categoria_id', '=', 'categorias.id')
            ->selectRaw('categorias.nome as cat_nome, COUNT(*) as total')
            ->groupBy('categorias.nome')
            ->pluck('total', 'cat_nome')
            ->toArray();

        // URL para celular (detecta IP local se estiver rodando em localhost)
        $localIp = '127.0.0.1';
        $ips = gethostbynamel(gethostname()) ?: [];
        
        // Prioriza IPs de rede local padrão (192.168.X.X ou 10.X.X.X)
        foreach ($ips as $ip) {
            if (str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
                $localIp = $ip;
                break;
            }
        }
        
        // Se não encontrar o padrão local, usa o gethostbyname padrão
        if ($localIp === '127.0.0.1' && !empty($ips)) {
            $localIp = gethostbyname(gethostname());
        }

        $isLocal = in_array(request()->getHost(), ['localhost', '127.0.0.1']);
        $mobileUrl = $isLocal ? "http://{$localIp}:8000" : url('/');

        // Geração do QR Code direto no PHP (100% robusto, offline e independente de JS)
        $qrCodeSvg = '';
        try {
            $options = new QROptions([
                'version'      => 4,
                'addQuietzone' => false,
            ]);
            $qrCodeSvg = (new QRCode($options))->render($mobileUrl);
        } catch (\Exception $e) {
            // Fallback caso ocorra erro
            $qrCodeSvg = '<div class="text-danger small">Erro ao gerar QR Code</div>';
        }

        return view('dashboard', compact(
            'totalCompetidores',
            'totalInscricoes',
            'totalSenhas',
            'totalFaturamento',
            'pagamentos',
            'senhasPorCategoria',
            'qrCodeSvg',
            'mobileUrl'
        ));
    }
}

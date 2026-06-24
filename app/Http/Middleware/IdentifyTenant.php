<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Parque;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Intercepta a requisição para identificar o tenant (Parque).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $tenant = null;

        // 1. Identificar por Domínio Customizado
        $tenant = Parque::where('custom_domain', $host)->first();

        // 2. Identificar por Subdomínio
        if (!$tenant) {
            $baseDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost';
            
            // Se o host atual termina com o domínio base e não é o próprio domínio base
            if (str_ends_with($host, $baseDomain) && $host !== $baseDomain) {
                // Extrair a parte do subdomínio
                $subdomain = str_replace('.' . $baseDomain, '', $host);
                
                // Ignorar subdomínios comuns do sistema principal
                if (!in_array($subdomain, ['www', 'admin', 'saas'])) {
                    $tenant = Parque::where('slug', $subdomain)->first();
                }
            }
        }

        // 3. Suporte a parâmetro de rota ou sessão/cookie para testes locais rápidos
        if (!$tenant && $request->has('tenant_id')) {
            $tenant = Parque::find($request->query('tenant_id'));
        }

        // Se encontrou o tenant
        if ($tenant) {
            // Verificar status
            if (!$tenant->isActive()) {
                abort(403, 'Este Parque de Vaquejada está desativado temporariamente.');
            }

            // Verificar licença expirada do parque
            if ($tenant->isExpired()) {
                return response()->view('errors.license_expired', [
                    'parque_nome' => $tenant->nome,
                    'expires_at' => $tenant->expires_at?->format('d/m/Y')
                ], 403);
            }

            // Registrar no TenantManager
            app('tenant')->set($tenant);

            // Carregar as configurações específicas do Parque no config('parque')
            $defaults = config('parque');
            config([
                'parque.name' => Setting::getValue('parque.name', $defaults['name'] ?? ''),
                'parque.city' => Setting::getValue('parque.city', $defaults['city'] ?? ''),
                'parque.state' => Setting::getValue('parque.state', $defaults['state'] ?? ''),
                'parque.contact' => Setting::getValue('parque.contact', $defaults['contact'] ?? ''),
                'parque.portal_enabled' => (bool)$tenant->portal_enabled,
            ]);
        }

        return $next($request);
    }
}

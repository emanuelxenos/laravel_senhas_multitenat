@extends('layout')

@section('page-title', 'Gerenciar Parques (SaaS)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 text-dark fw-bold">Parques de Vaquejada</h4>
        <p class="text-muted small mb-0">Cadastre e gerencie a expiração e configurações dos parques ativos no sistema.</p>
    </div>
    <button type="button" class="btn btn-warning fw-bold text-dark px-4" data-bs-toggle="modal" data-bs-target="#modalNovoParque">
        <i class="fas fa-plus me-2"></i> Novo Parque
    </button>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                <thead class="table-light text-uppercase fs-7 fw-semibold text-muted">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nome do Parque</th>
                        <th>Identificador (Slug)</th>
                        <th>Domínio Personalizado</th>
                        <th>Split Gateway</th>
                        <th>Comissão</th>
                        <th>Status</th>
                        <th>Expiração de Licença</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-secondary fs-6">
                    @forelse($parques as $parque)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">#{{ $parque->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $parque->nome }}</div>
                                <span class="text-muted small">Criado em: {{ $parque->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1.5 font-monospace">
                                    {{ $parque->slug }}
                                </span>
                            </td>
                            <td>
                                @if($parque->custom_domain)
                                    <a href="http://{{ $parque->custom_domain }}" target="_blank" class="text-decoration-none text-warning">
                                        {{ $parque->custom_domain }}
                                    </a>
                                @else
                                    <span class="text-muted small">Não configurado</span>
                                @endif
                            </td>
                            <td>
                                @if($parque->gateway_recipient_id)
                                    <span class="badge bg-secondary px-2 py-1.5 small">
                                        <i class="fas fa-wallet me-1"></i> {{ substr($parque->gateway_recipient_id, 0, 10) }}...
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small fw-bold">Venda Online Bloqueada</span>
                                @endif
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ number_format($parque->comissao_percentual, 2, ',', '.') }}%</div>
                                <div class="text-muted small">+ R$ {{ number_format($parque->comissao_fixa, 2, ',', '.') }}</div>
                            </td>
                            <td>
                                @if($parque->isActive())
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Ativo</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inativo</span>
                                @endif
                            </td>
                            <td>
                                @if($parque->expires_at)
                                    <span class="fw-semibold @if($parque->isExpired()) text-danger @else text-dark @endif">
                                        {{ $parque->expires_at->format('d/m/Y') }}
                                        @if($parque->isExpired())
                                            <span class="badge bg-danger text-white ms-1 small">Expirado</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-success fw-bold">Vitalício</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Acesso Rápido -->
                                    <a href="http://{{ $parque->slug }}.localhost:8000" target="_blank" class="btn btn-sm btn-outline-secondary" title="Acessar Parque">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    
                                    <!-- Editar -->
                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditarParque{{ $parque->id }}" 
                                            title="Editar Configurações">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Excluir -->
                                    <form action="{{ route('saas.parques.destroy', $parque) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este parque? Todos os dados associados a ele serão excluídos permanentemente!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Parque">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Editar Parque -->
                        <div class="modal fade" id="modalEditarParque{{ $parque->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('saas.parques.update', $parque) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Editar Parque</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nome do Parque</label>
                                                <input type="text" name="nome" value="{{ $parque->nome }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Slug (Subdomínio)</label>
                                                <input type="text" name="slug" value="{{ $parque->slug }}" class="form-control" required>
                                                <div class="form-text small">Ex: 'parque-boa-vista' gerará o link 'parque-boa-vista.localhost:8000'</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Domínio Próprio (Opcional)</label>
                                                <input type="text" name="custom_domain" value="{{ $parque->custom_domain }}" class="form-control" placeholder="ex: www.parqueboavista.com.br">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">ID Recebedor Gateway (Split de Pagamento)</label>
                                                <input type="text" name="gateway_recipient_id" value="{{ $parque->gateway_recipient_id }}" class="form-control" placeholder="ID da carteira no gateway (Asaas, etc.)">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Taxa Comissão (%)</label>
                                                    <input type="number" step="0.01" min="0" max="100" name="comissao_percentual" value="{{ $parque->comissao_percentual }}" class="form-control" placeholder="0.00">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Taxa Fixa por Senha (R$)</label>
                                                    <input type="number" step="0.01" min="0" name="comissao_fixa" value="{{ $parque->comissao_fixa }}" class="form-control" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="ativo" {{ $parque->status === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                                        <option value="inativo" {{ $parque->status === 'inativo' ? 'selected' : '' }}>Inativo</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Expiração da Licença</label>
                                                    <input type="date" name="expires_at" value="{{ $parque->expires_at ? $parque->expires_at->format('Y-m-d') : '' }}" class="form-control">
                                                    <div class="form-text small">Deixe em branco para vitalício</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning text-dark fw-bold">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-cubes fa-2x mb-3 text-light"></i>
                                <p class="mb-0">Nenhum Parque de Vaquejada cadastrado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($parques->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-center">
                    {{ $parques->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Novo Parque -->
<div class="modal fade" id="modalNovoParque" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('saas.parques.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Cadastrar Novo Parque</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Parque</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: Parque Boa Vista" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug (Subdomínio)</label>
                        <input type="text" name="slug" class="form-control" placeholder="Ex: parque-boa-vista" required>
                        <div class="form-text small">Ex: 'parque-boa-vista' gerará o link 'parque-boa-vista.localhost:8000'</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Domínio Próprio (Opcional)</label>
                        <input type="text" name="custom_domain" class="form-control" placeholder="ex: www.parqueboavista.com.br">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID Recebedor Gateway (Split de Pagamento)</label>
                        <input type="text" name="gateway_recipient_id" class="form-control" placeholder="ID da carteira no gateway (Asaas, etc.)">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Taxa Comissão (%)</label>
                            <input type="number" step="0.01" min="0" max="100" name="comissao_percentual" class="form-control" placeholder="0.00" value="0.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Taxa Fixa por Senha (R$)</label>
                            <input type="number" step="0.01" min="0" name="comissao_fixa" class="form-control" placeholder="0.00" value="0.00">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Expiração da Licença</label>
                            <input type="date" name="expires_at" class="form-control">
                            <div class="form-text small">Deixe em branco para vitalício</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Cadastrar Parque</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

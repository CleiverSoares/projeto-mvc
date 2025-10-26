@extends('layouts.app')

@section('title', 'Detalhes da Pessoa')
@section('page-title', 'Detalhes da Pessoa')

@section('content')
<div class="container-fluid">
    @if($pessoa)
        <!-- Cabeçalho com Foto -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center">
                        @if($pessoa->foto_pessoa)
                            <img src="{{ asset('storage/' . $pessoa->foto_pessoa) }}" class="img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3 class="mb-1">{{ $pessoa->nome_pessoa }}</h3>
                        <p class="text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>
                            Nascimento: {{ \Carbon\Carbon::parse($pessoa->data_nasc_pessoa)->format('d/m/Y') }}
                            ({{ $pessoa->idade ?? \Carbon\Carbon::parse($pessoa->data_nasc_pessoa)->age }} anos)
                        </p>
                        <p class="text-muted mb-0">
                            <i class="fas fa-envelope me-1"></i>{{ $pessoa->email_pessoa }}
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <span class="badge {{ $pessoa->status_participacao == 'Ativo' ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2">
                            {{ $pessoa->status_participacao }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados Pessoais -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <strong>CPF:</strong><br>
                        {{ $pessoa->cpf_pessoa }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>RG:</strong><br>
                        {{ $pessoa->rg_pessoa ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Sexo:</strong><br>
                        {{ $pessoa->sexo_pessoa }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Estado Civil:</strong><br>
                        {{ $pessoa->estado_civil ?? '-' }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Cor/Raça:</strong><br>
                        {{ $pessoa->cor_raca ?? '-' }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Nacionalidade:</strong><br>
                        {{ $pessoa->nacionalidade }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Naturalidade:</strong><br>
                        {{ $pessoa->naturalidade ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Contatos -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contatos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        {{ $pessoa->email_pessoa }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Telefone:</strong><br>
                        {{ $pessoa->telefone_pessoa }}
                    </div>
                </div>
                
                @if($pessoa->telefone_emergencia)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Telefone Emergência:</strong><br>
                            {{ $pessoa->telefone_emergencia }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Contato:</strong><br>
                            {{ $pessoa->contato_emergencia_nome }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Endereço -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <strong>Endereço:</strong><br>
                        {{ $pessoa->endereco_pessoa ?? '-' }}, {{ $pessoa->numero_endereco ?? '' }} {{ $pessoa->complemento_endereco ? ' - ' . $pessoa->complemento_endereco : '' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Bairro:</strong><br>
                        {{ $pessoa->bairro_pessoa ?? '-' }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Cidade:</strong><br>
                        {{ $pessoa->cidade_pessoa ?? '-' }}
                    </div>
                    <div class="col-md-2 mb-3">
                        <strong>Estado:</strong><br>
                        {{ $pessoa->estado_pessoa ?? '-' }}
                    </div>
                    <div class="col-md-2 mb-3">
                        <strong>CEP:</strong><br>
                        {{ $pessoa->cep_pessoa ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados Socioeconômicos -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Dados Socioeconômicos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <strong>Profissão:</strong><br>
                        {{ $pessoa->profissao_pessoa ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Escolaridade:</strong><br>
                        {{ $pessoa->escolaridade ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Renda Familiar:</strong><br>
                        {{ $pessoa->renda_familiar ? 'R$ ' . number_format($pessoa->renda_familiar, 2, ',', '.') : '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Situação de Trabalho:</strong><br>
                        {{ $pessoa->situacao_trabalho ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados de Saúde -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Dados de Saúde</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <strong>Tipo Sanguíneo:</strong><br>
                        {{ $pessoa->tipo_sangue ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Possui Deficiência:</strong><br>
                        {{ $pessoa->possui_deficiencia ? 'Sim' : 'Não' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Plano de Saúde:</strong><br>
                        {{ $pessoa->plano_saude ? 'Sim' : 'Não' }}
                    </div>
                </div>
                @if($pessoa->alergias)
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <strong>Alergias:</strong><br>
                            {{ $pessoa->alergias }}
                        </div>
                    </div>
                @endif
                @if($pessoa->medicamentos_uso)
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <strong>Medicamentos em Uso:</strong><br>
                            {{ $pessoa->medicamentos_uso }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Documentos -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Documentos Anexados</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $detectarTipo = function($arquivo) {
                            if (!$arquivo) return null;
                            $ext = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                            return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'imagem' : 'documento';
                        };
                    @endphp
                    
                    @if($pessoa->documento_cpf)
                        <div class="col-md-4 mb-4">
                            <strong>CPF (Documento)</strong>
                            <div class="documento-preview mt-2" onclick="abrirDocumento('{{ asset('storage/' . $pessoa->documento_cpf) }}', '{{ $detectarTipo($pessoa->documento_cpf) }}')" style="cursor: pointer;">
                                @if($detectarTipo($pessoa->documento_cpf) == 'imagem')
                                    <img src="{{ asset('storage/' . $pessoa->documento_cpf) }}" class="img-fluid border rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: contain;">
                                @else
                                    <div class="text-center p-3 border rounded bg-light d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                        <div>
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                            <p class="mt-2 mb-0">Clique para visualizar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ asset('storage/' . $pessoa->documento_cpf) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 w-100">
                                <i class="fas fa-download me-1"></i>Baixar
                            </a>
                        </div>
                    @endif
                    @if($pessoa->documento_rg)
                        <div class="col-md-4 mb-4">
                            <strong>RG (Documento)</strong>
                            <div class="documento-preview mt-2" onclick="abrirDocumento('{{ asset('storage/' . $pessoa->documento_rg) }}', '{{ $detectarTipo($pessoa->documento_rg) }}')" style="cursor: pointer;">
                                @if($detectarTipo($pessoa->documento_rg) == 'imagem')
                                    <img src="{{ asset('storage/' . $pessoa->documento_rg) }}" class="img-fluid border rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: contain;">
                                @else
                                    <div class="text-center p-3 border rounded bg-light d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                        <div>
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                            <p class="mt-2 mb-0">Clique para visualizar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ asset('storage/' . $pessoa->documento_rg) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 w-100">
                                <i class="fas fa-download me-1"></i>Baixar
                            </a>
                        </div>
                    @endif
                    @if($pessoa->comprovante_residencia)
                        <div class="col-md-4 mb-4">
                            <strong>Comprovante de Residência</strong>
                            <div class="documento-preview mt-2" onclick="abrirDocumento('{{ asset('storage/' . $pessoa->comprovante_residencia) }}', '{{ $detectarTipo($pessoa->comprovante_residencia) }}')" style="cursor: pointer;">
                                @if($detectarTipo($pessoa->comprovante_residencia) == 'imagem')
                                    <img src="{{ asset('storage/' . $pessoa->comprovante_residencia) }}" class="img-fluid border rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: contain;">
                                @else
                                    <div class="text-center p-3 border rounded bg-light d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                        <div>
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                            <p class="mt-2 mb-0">Clique para visualizar</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ asset('storage/' . $pessoa->comprovante_residencia) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 w-100">
                                <i class="fas fa-download me-1"></i>Baixar
                            </a>
                        </div>
                    @endif
                </div>
                @if(!$pessoa->documento_cpf && !$pessoa->documento_rg && !$pessoa->comprovante_residencia)
                    <p class="text-muted text-center mb-0">Nenhum documento anexado</p>
                @endif
            </div>
        </div>

        <!-- Ações -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex gap-2">
                    @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                    <a href="{{ route('pessoas.edit', $pessoa->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir esta pessoa?')">
                            <i class="fas fa-trash me-2"></i>Excluir
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Pessoa não encontrada
        </div>
    @endif

    <!-- Modal para expandir documento -->
    <div class="modal fade" id="documentoModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visualizar Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="documentoImagem" src="" class="img-fluid" style="max-height: 80vh; display: none;">
                    <iframe id="documentoPDF" src="" style="display: none; width: 100%; height: 600px; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function abrirDocumento(url, tipo) {
        console.log('Abrindo documento:', url, tipo);
        
        const modalElement = document.getElementById('documentoModal');
        const img = document.getElementById('documentoImagem');
        const iframe = document.getElementById('documentoPDF');
        
        if (!modalElement) {
            console.error('Modal não encontrado');
            alert('Modal não encontrado. Recarregando a página...');
            location.reload();
            return;
        }
        
        // Limpar anteriores
        if (img) {
            img.src = '';
            img.style.display = 'none';
        }
        if (iframe) {
            iframe.src = '';
            iframe.style.display = 'none';
        }
        
        // Verificar tipo
        if (tipo === 'imagem' || url.toLowerCase().match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
            // Mostrar imagem
            if (img) {
                img.src = url;
                img.style.display = 'block';
                img.style.maxHeight = '80vh';
                img.style.objectFit = 'contain';
            }
        } else {
            // Abrir em nova aba
            window.open(url, '_blank');
            return;
        }
        
        // Abrir modal com Bootstrap
        try {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } catch(e) {
            console.error('Erro ao abrir modal:', e);
            alert('Erro ao abrir modal. Abrindo em nova aba...');
            window.open(url, '_blank');
        }
    }
    
    console.log('Função abrirDocumento carregada');
</script>
@endpush

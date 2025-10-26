@extends('layouts.app')

@section('title', 'Relatórios')
@section('page-title', 'Relatórios e Estatísticas')

@section('content')
<div class="container-fluid">
    <!-- Mensagens -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros para Relatório</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('relatorios.gerar') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tipo de Relatório</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="pessoas">Lista de Pessoas</option>
                            <option value="projetos">Participantes por Projeto</option>
                            <option value="eventos">Presença em Eventos</option>
                            <option value="doacoes">Doações Registradas</option>
                            <option value="completo">Relatório Completo</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Período - De</label>
                        <input type="date" name="data_inicio" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Até</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Formato</label>
                        <select name="formato" class="form-select">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Projeto</label>
                        <select name="projeto_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($projetos as $projeto)
                                <option value="{{ $projeto->id }}">{{ $projeto->nome_projeto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Gerar Relatório
                </button>
            </form>
        </div>
    </div>

    <!-- Relatórios Rápidos -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Relatórios Rápidos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <form action="{{ route('relatorios.gerar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="pessoas">
                        <input type="hidden" name="formato" value="pdf">
                        <div class="card">
                            <div class="card-body">
                                <h6>Lista de Participantes</h6>
                                <p class="text-muted">Todos os participantes cadastrados</p>
                                <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Baixar PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-4 mb-3">
                    <form action="{{ route('relatorios.gerar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="completo">
                        <input type="hidden" name="formato" value="excel">
                        <input type="hidden" name="data_inicio" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                        <input type="hidden" name="data_fim" value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                        <div class="card">
                            <div class="card-body">
                                <h6>Estatísticas do Mês</h6>
                                <p class="text-muted">Resumo mensal completo</p>
                                <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                    <i class="fas fa-file-excel me-1"></i>Baixar Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-4 mb-3">
                    <form action="{{ route('relatorios.gerar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="doacoes">
                        <input type="hidden" name="formato" value="pdf">
                        <div class="card">
                            <div class="card-body">
                                <h6>Relatório de Doações</h6>
                                <p class="text-muted">Todas as doações registradas</p>
                                <button type="submit" class="btn btn-sm btn-outline-warning w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Baixar PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

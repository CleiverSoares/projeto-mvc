@extends('layouts.app')

@section('title', 'Projetos')
@section('page-title', 'Projetos Cadastrados')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-project-diagram text-primary me-2"></i>
            Projetos
        </h2>
        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
        <a href="{{ route('projetos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Projeto
        </a>
        @endif
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('projetos.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Buscar</label>
                        <input type="text" name="search" class="form-control" placeholder="Nome do projeto...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas</option>
                            <option value="">Categorias...</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="Ativo">Ativo</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Pausado">Pausado</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Grid de Projetos -->
    <div class="row">
        @for($i = 1; $i <= 6; $i++)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-running text-primary me-2"></i>
                        Projeto {{ $i }}
                    </h5>
                    <span class="badge bg-success">Ativo</span>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Descrição do projeto e objetivos principais em destaque.
                    </p>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Categoria</small>
                            <strong>Esportes</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Vagas</small>
                            <strong>15 / 20</strong>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Início</small>
                            <strong>01/01/2025</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Idade</small>
                            <strong>10 - 18 anos</strong>
                        </div>
                    </div>
                    
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('projetos.show', $i) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                        <a href="{{ route('projetos.show', $i) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-users me-1"></i>Participantes
                        </a>
                        <a href="{{ route('projetos.edit', $i) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection

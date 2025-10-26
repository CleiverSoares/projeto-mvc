@extends('layouts.app')

@section('title', 'Detalhes do Projeto')
@section('page-title', 'Detalhes do Projeto')

@section('content')
<div class="container-fluid">
    @if($projeto)
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">{{ $projeto->nome_projeto }}</h5>
            <span class="badge bg-light text-dark">{{ $projeto->status_projeto }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Categoria:</strong><br>
                    {{ $projeto->categoria->nome_categoria ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Período:</strong><br>
                    {{ $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' }} até {{ $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Vagas:</strong><br>
                    {{ $projeto->vagas_preenchidas ?? 0 }} ocupadas de {{ $projeto->vagas_disponiveis ?? 0 }} total
                </div>
            </div>
            
            <div class="progress mb-3" style="height: 10px;">
                <div class="progress-bar bg-success" style="width: {{ $projeto->percentual_ocupacao ?? 0 }}%"></div>
            </div>
            
            @if($projeto->descricao_projeto)
                <h6 class="mb-3">Descrição</h6>
                <p>{{ $projeto->descricao_projeto }}</p>
            @endif
            
            @if($projeto->objetivos_projeto)
                <h6 class="mb-3">Objetivos</h6>
                <p>{{ $projeto->objetivos_projeto }}</p>
            @endif
            
            <h6 class="mb-3 mt-4">Estatísticas</h6>
            <div class="row">
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-0">{{ $projeto->vagas_preenchidas ?? 0 }}</h3>
                            <small>Participantes</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-0">{{ round($projeto->percentual_ocupacao ?? 0) }}%</h3>
                            <small>Ocupação</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-0">{{ $projeto->vagas_restantes ?? 0 }}</h3>
                            <small>Vagas Restantes</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-0">
                                @if($projeto->data_inicio && $projeto->data_fim)
                                    {{ $projeto->data_inicio->diffInMonths($projeto->data_fim) }}
                                @else
                                    -
                                @endif
                            </h3>
                            <small>Meses de Duração</small>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($projeto->local_projeto)
                <h6 class="mb-3 mt-4">Localização</h6>
                <p><i class="fas fa-map-marker-alt me-2"></i>{{ $projeto->local_projeto }}</p>
            @endif
            
            <div class="d-flex gap-2 mt-4">
                @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                @endif
                <a href="{{ route('projetos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger">
            Projeto não encontrado
        </div>
    @endif
</div>
@endsection


@extends('layouts.app')

@section('title', 'Detalhes do Evento')
@section('page-title', 'Detalhes do Evento')

@section('content')
<div class="container-fluid">
    @if($evento)
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $evento->nome_evento }}</h5>
                <span class="badge bg-light text-dark">{{ $evento->status_evento }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tipo:</strong><br>
                        {{ $evento->tipo_evento }}
                    </div>
                    <div class="col-md-6">
                        <strong>Data:</strong><br>
                        {{ $evento->data_evento ? $evento->data_evento->format('d/m/Y') : '-' }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Horário:</strong><br>
                        {{ $evento->hora_inicio ? $evento->hora_inicio->format('H:i') : '-' }}
                        @if($evento->hora_fim)
                            até {{ $evento->hora_fim->format('H:i') }}
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Local:</strong><br>
                        {{ $evento->local_evento }}
                    </div>
                </div>
                
                @if($evento->vagas_evento)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Capacidade:</strong><br>
                            {{ $evento->vagas_evento }} vagas
                        </div>
                    </div>
                @endif
                
                @if($evento->descricao_evento)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Descrição:</strong><br>
                            <p>{{ $evento->descricao_evento }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Evento não encontrado
        </div>
    @endif
</div>
@endsection

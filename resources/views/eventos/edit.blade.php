@extends('layouts.app')

@section('title', 'Editar Evento')
@section('page-title', 'Editar Evento')

@section('content')
<div class="container-fluid">
    @if(isset($evento) && $evento)
        <form action="{{ route('eventos.update', $evento->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Editando: {{ $evento->nome_evento }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nome do Evento *</label>
                            <input type="text" name="nome_evento" class="form-control" value="{{ old('nome_evento', $evento->nome_evento) }}" required maxlength="250">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo *</label>
                            <select name="tipo_evento" class="form-select" required>
                                <option value="Reunião" {{ $evento->tipo_evento == 'Reunião' ? 'selected' : '' }}>Reunião</option>
                                <option value="Atividade" {{ $evento->tipo_evento == 'Atividade' ? 'selected' : '' }}>Atividade</option>
                                <option value="Evento" {{ $evento->tipo_evento == 'Evento' ? 'selected' : '' }}>Evento</option>
                                <option value="Palestra" {{ $evento->tipo_evento == 'Palestra' ? 'selected' : '' }}>Palestra</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data *</label>
                            <input type="date" name="data_evento" class="form-control" value="{{ old('data_evento', $evento->data_evento?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hora Início *</label>
                            <input type="time" name="hora_inicio" class="form-control" value="{{ old('hora_inicio', $evento->hora_inicio?->format('H:i')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hora Fim</label>
                            <input type="time" name="hora_fim" class="form-control" value="{{ old('hora_fim', $evento->hora_fim?->format('H:i')) }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Local *</label>
                            <input type="text" name="local_evento" class="form-control" value="{{ old('local_evento', $evento->local_evento) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Vagas Máximas</label>
                            <input type="number" name="vagas_evento" class="form-control" value="{{ old('vagas_evento', $evento->vagas_evento ?? 30) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_evento" class="form-select">
                                <option value="Aguardando" {{ $evento->status_evento == 'Aguardando' ? 'selected' : '' }}>Aguardando</option>
                                <option value="Confirmado" {{ $evento->status_evento == 'Confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="Realizado" {{ $evento->status_evento == 'Realizado' ? 'selected' : '' }}>Realizado</option>
                                <option value="Cancelado" {{ $evento->status_evento == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($evento->descricao_evento)
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao_evento" class="form-control" rows="3">{{ old('descricao_evento', $evento->descricao_evento) }}</textarea>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-danger">
            Evento não encontrado
        </div>
    @endif
</div>
@endsection

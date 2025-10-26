@extends('layouts.app')

@section('title', 'Novo Evento')
@section('page-title', 'Novo Evento')

@section('content')
<div class="container-fluid">
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Dados do Evento</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nome do Evento *</label>
                        <input type="text" name="nome_evento" class="form-control" required maxlength="250">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo *</label>
                        <select name="tipo_evento" class="form-select" required>
                            <option value="Reunião">Reunião</option>
                            <option value="Atividade">Atividade</option>
                            <option value="Evento">Evento</option>
                            <option value="Palestra">Palestra</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data *</label>
                        <input type="date" name="data_evento" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Hora Início *</label>
                        <input type="time" name="hora_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Hora Fim</label>
                        <input type="time" name="hora_fim" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Local *</label>
                        <input type="text" name="local_evento" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Vagas Máximas</label>
                        <input type="number" name="vagas_evento" class="form-control" value="30">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_evento" class="form-select">
                            <option value="Aguardando">Aguardando</option>
                            <option value="Confirmado">Confirmado</option>
                            <option value="Realizado">Realizado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao_evento" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('eventos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Evento
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


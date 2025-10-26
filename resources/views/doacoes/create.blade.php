@extends('layouts.app')

@section('title', 'Registrar Doação')
@section('page-title', 'Registrar Doação')

@section('content')
<div class="container-fluid">
    <form action="{{ route('doacoes.store') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Informações da Doação</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Doador *</label>
                        <input type="text" name="nome_doador" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data *</label>
                        <input type="date" name="data_doacao" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Doação *</label>
                        <select name="tipo_doacao" class="form-select" required>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Material">Material</option>
                            <option value="Alimentação">Alimentação</option>
                            <option value="Serviço">Serviço</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valor *</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" name="valor_doacao" class="form-control" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Forma de Pagamento</label>
                        <select name="forma_pagamento" class="form-select">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Pix">Pix</option>
                            <option value="Transferência">Transferência</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Cartão">Cartão</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status_doacao" class="form-select" required>
                            <option value="Confirmado">Confirmado</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Processando">Processando</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Observações</label>
                    <textarea name="observacoes" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('doacoes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Registrar Doação
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


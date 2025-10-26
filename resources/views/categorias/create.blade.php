@extends('layouts.app')

@section('title', 'Nova Categoria')
@section('page-title', 'Nova Categoria')

@section('content')
<div class="container-fluid">
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Dados da Categoria</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nome da Categoria *</label>
                        <input type="text" name="nome_categoria" class="form-control" required maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cor</label>
                        <select name="cor_categoria" class="form-select">
                            <option value="primary">Azul</option>
                            <option value="success">Verde</option>
                            <option value="warning">Amarelo</option>
                            <option value="danger">Vermelho</option>
                            <option value="info">Ciano</option>
                            <option value="dark">Preto</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ícone (Font Awesome)</label>
                        <input type="text" name="icone_categoria" class="form-control" placeholder="Ex: running">
                        <small class="text-muted">Digite apenas o nome do ícone (sem fa-)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_categoria" class="form-select">
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao_categoria" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Categoria
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


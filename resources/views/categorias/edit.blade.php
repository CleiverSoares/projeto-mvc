@extends('layouts.app')

@section('title', 'Editar Categoria')
@section('page-title', 'Editar Categoria')

@section('content')
<div class="container-fluid">
    @if(isset($categoria) && $categoria)
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Editando: {{ $categoria->nome_categoria }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nome da Categoria *</label>
                            <input type="text" name="nome_categoria" class="form-control" value="{{ old('nome_categoria', $categoria->nome_categoria) }}" required maxlength="100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cor</label>
                            <select name="cor_categoria" class="form-select">
                                <option value="primary" {{ $categoria->cor_categoria == 'primary' ? 'selected' : '' }}>Azul</option>
                                <option value="success" {{ $categoria->cor_categoria == 'success' ? 'selected' : '' }}>Verde</option>
                                <option value="warning" {{ $categoria->cor_categoria == 'warning' ? 'selected' : '' }}>Amarelo</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($categoria->descricao_categoria)
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao_categoria" class="form-control" rows="3">{{ old('descricao_categoria', $categoria->descricao_categoria) }}</textarea>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-danger">
            Categoria não encontrada
        </div>
    @endif
</div>
@endsection

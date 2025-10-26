@extends('layouts.app')

@section('title', 'Editar Projeto')
@section('page-title', 'Editar Projeto')

@section('content')
<div class="container-fluid">
    @if(isset($projeto) && $projeto)
        <form action="{{ route('projetos.update', $projeto->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-project me-2"></i>Editando: {{ $projeto->nome_projeto }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nome do Projeto *</label>
                            <input type="text" name="nome_projeto" class="form-control" value="{{ old('nome_projeto', $projeto->nome_projeto) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Categoria *</label>
                            <select name="categoria_id" class="form-select" required>
                                @foreach(\App\Models\Categoria::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ $projeto->categoria_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nome_categoria }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data Início *</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ old('data_inicio', $projeto->data_inicio?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data Fim *</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ old('data_fim', $projeto->data_fim?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Vagas Disponíveis</label>
                            <input type="number" name="vagas_disponiveis" class="form-control" value="{{ old('vagas_disponiveis', $projeto->vagas_disponiveis) }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_projeto" class="form-select">
                                <option value="Ativo" {{ $projeto->status_projeto == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ $projeto->status_projeto == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                <option value="Concluído" {{ $projeto->status_projeto == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($projeto->descricao_projeto)
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao_projeto" class="form-control" rows="3">{{ old('descricao_projeto', $projeto->descricao_projeto) }}</textarea>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('projetos.index') }}" class="btn btn-secondary">
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
            Projeto não encontrado
        </div>
    @endif
</div>
@endsection

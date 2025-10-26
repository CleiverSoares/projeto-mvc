@extends('layouts.app')

@section('title', 'Detalhes da Categoria')
@section('page-title', 'Detalhes da Categoria')

@section('content')
<div class="container-fluid">
    @if(isset($categoria) && $categoria)
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                        <i class="fas fa-folder fa-4x text-primary"></i>
                    </div>
                </div>
                <h3 class="mb-3">{{ $categoria->nome_categoria }}</h3>
                
                <div class="row mt-4">
                    <div class="col-md-6 mx-auto">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="text-muted">Status</h6>
                                <p class="mb-0">
                                    @if($categoria->status_categoria == 'Ativo')
                                        <span class="badge bg-success">{{ $categoria->status_categoria }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $categoria->status_categoria }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="text-muted">Cor da Categoria</h6>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="rounded" style="width: 40px; height: 40px; background-color: {{ $categoria->cor_categoria ?? '#007BFF' }}; border: 2px solid #ddd;"></div>
                                    <span class="ms-3">{{ $categoria->cor_categoria ?? 'Azul' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($categoria->descricao_categoria)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">Descrição</h6>
                                    <p class="mb-0">{{ $categoria->descricao_categoria }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-4">
                    @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    @endif
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Categoria não encontrada
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Categorias')
@section('page-title', 'Categorias do Sistema')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-tags text-primary me-2"></i>
            Categorias
        </h2>
        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nova Categoria
        </a>
        @endif
    </div>

    <!-- Categorias em Grid -->
    <div class="row">
        @foreach([
            ['nome' => 'Esportes', 'cor' => 'primary', 'icone' => 'running', 'total' => 120, 'id' => 1],
            ['nome' => 'Educação', 'cor' => 'success', 'icone' => 'book', 'total' => 85, 'id' => 2],
            ['nome' => 'Cultura', 'cor' => 'warning', 'icone' => 'theater-masks', 'total' => 50, 'id' => 3],
            ['nome' => 'Saúde', 'cor' => 'danger', 'icone' => 'heartbeat', 'total' => 60, 'id' => 4],
            ['nome' => 'Tecnologia', 'cor' => 'info', 'icone' => 'laptop', 'total' => 40, 'id' => 5],
            ['nome' => 'Meio Ambiente', 'cor' => 'success', 'icone' => 'leaf', 'total' => 30, 'id' => 6],
        ] as $categoria)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-{{ $categoria['cor'] }} bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-{{ $categoria['icone'] }} fa-2x text-{{ $categoria['cor'] }}"></i>
                        </div>
                    </div>
                    <h5 class="card-title">{{ $categoria['nome'] }}</h5>
                    <p class="text-muted mb-3">{{ $categoria['total'] }} participantes</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('categorias.show', $categoria['id']) }}" class="btn btn-sm btn-{{ $categoria['cor'] }}">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                        <a href="{{ route('categorias.edit', $categoria['id']) }}" class="btn btn-sm btn-outline-{{ $categoria['cor'] }}">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

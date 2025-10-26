@extends('layouts.app')

@section('title', 'Pessoas Cadastradas')
@section('page-title', 'Pessoas Cadastradas')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-users text-primary-blue me-2"></i>
            Pessoas Cadastradas
        </h2>
        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
        <a href="{{ route('pessoas.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-2"></i>
            Nova Pessoa
        </a>
        @endif
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pessoas.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $filtros['nome'] ?? '' }}" placeholder="Digite o nome">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="{{ $filtros['cidade'] ?? '' }}" placeholder="Cidade">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="Ativo" {{ ($filtros['status'] ?? '') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ ($filtros['status'] ?? '') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ ($filtros['categoria_id'] ?? '') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100 me-2">
                            <i class="fas fa-search me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('pessoas.index') }}" class="btn btn-secondary-custom">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="card">
        <div class="card-body">
            @if($pessoas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Cidade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pessoas as $pessoa)
                                <tr>
                                    <td>{{ $pessoa->nome_pessoa }}</td>
                                    <td>{{ $pessoa->email_pessoa }}</td>
                                    <td>{{ $pessoa->telefone_pessoa }}</td>
                                    <td>{{ $pessoa->cidade_pessoa ?? '-' }}</td>
                                    <td>
                                        @if($pessoa->status_participacao == 'Ativo')
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $pessoa->status_participacao }}</span>
                                        @endif
                                    </td>
                            <td>
                                <a href="{{ route('pessoas.show', $pessoa->id) }}" class="btn btn-sm btn-info-custom" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                                <a href="{{ route('pessoas.edit', $pessoa->id) }}" class="btn btn-sm btn-warning-custom" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger-custom" onclick="return confirm('Deseja realmente excluir?')" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="mt-3">
                    {{ $pessoas->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Nenhuma pessoa cadastrada ainda.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


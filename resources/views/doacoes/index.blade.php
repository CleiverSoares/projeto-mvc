@extends('layouts.app')

@section('title', 'Doações')
@section('page-title', 'Registro de Doações')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-hand-holding-usd text-success me-2"></i>
            Doações
        </h2>
        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
        <a href="{{ route('doacoes.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Registrar Doação
        </a>
        @endif
    </div>

    <!-- Cards Resumo -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total Arrecadado</h6>
                    <h3 class="mb-0">R$ 15.850,00</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Este Mês</h6>
                    <h3 class="mb-0">R$ 3.250,00</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total de Doadores</h6>
                    <h3 class="mb-0">48</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Doações Pendentes</h6>
                    <h3 class="mb-0">5</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('doacoes.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Período - De</label>
                        <input type="date" name="data_inicio" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Até</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Material">Material</option>
                            <option value="Alimentação">Alimentação</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Doador</th>
                            <th>Valor/Descrição</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>{{ now()->subDays($i)->format('d/m/Y') }}</td>
                            <td>Doador {{ $i }}</td>
                            <td>R$ {{ number_format(rand(50, 500), 2, ',', '.') }}</td>
                            <td><span class="badge bg-success">Dinheiro</span></td>
                            <td><span class="badge bg-success">Confirmado</span></td>
                            <td>
                                <a href="{{ route('doacoes.show', $i) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

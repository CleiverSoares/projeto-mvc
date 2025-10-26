@extends('layouts.app')

@section('title', 'Eventos')
@section('page-title', 'Eventos Cadastrados')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-calendar-alt text-primary me-2"></i>
            Eventos
        </h2>
        @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Evento
        </a>
        @endif
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('eventos.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Buscar</label>
                        <input type="text" name="search" class="form-control" placeholder="Nome do evento...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Mês</label>
                        <input type="month" name="mes" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="Reunião">Reunião</option>
                            <option value="Atividade">Atividade</option>
                            <option value="Evento">Evento</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Eventos -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Tipo</th>
                            <th>Local</th>
                            <th>Participantes</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td><strong>Reunião Mensal {{ $i }}</strong></td>
                            <td>{{ now()->addDays($i)->format('d/m/Y') }}</td>
                            <td>14:00</td>
                            <td><span class="badge bg-info">Reunião</span></td>
                            <td>Quadra Principal</td>
                            <td>25/30</td>
                            <td>
                                <a href="{{ route('eventos.show', $i) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor']))
                                <a href="{{ route('eventos.edit', $i) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
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

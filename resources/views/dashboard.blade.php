@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-chart-line text-primary me-2"></i>Dashboard</h2>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data Início</label>
                        <input type="month" name="mes_inicio" class="form-control" value="{{ request('mes_inicio', date('Y-m')) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data Fim</label>
                        <input type="month" name="mes_fim" class="form-control" value="{{ request('mes_fim', date('Y-m')) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach(\App\Models\Categoria::all() as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome_categoria }}
                                </option>
                            @endforeach
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

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total de Participantes</h6>
                            <h3 class="mb-0">{{ $total_participantes ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $participantes_mes ?? 0 }} este mês
                            </small>
                        </div>
                        <div class="text-primary" style="font-size: 2.5rem;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Projetos Ativos</h6>
                            <h3 class="mb-0">{{ $projetos_ativos ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $novos_projetos ?? 0 }} novos
                            </small>
                        </div>
                        <div class="text-success" style="font-size: 2.5rem;">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Doações Recebidas</h6>
                            <h3 class="mb-0">R$ {{ number_format($total_doacoes ?? 0, 2, ',', '.') }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                R$ {{ number_format($doacoes_mes ?? 0, 2, ',', '.') }} este mês
                            </small>
                        </div>
                        <div class="text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Eventos Realizados</h6>
                            <h3 class="mb-0">{{ $eventos_realizados ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $eventos_mes ?? 0 }} este mês
                            </small>
                        </div>
                        <div class="text-info" style="font-size: 2.5rem;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos - Oculto no mobile -->
    <div class="row mb-4 d-none d-md-flex">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolução de Participantes</h5>
                </div>
                <div class="card-body">
                    <canvas id="participantesChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Por Categoria</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoriasChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Participantes Recentes -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Participantes Recentes</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="participantesTable">
                        <!-- Será preenchido via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        height: 100%;
    }
    .card-body h3 {
        font-size: 2rem;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dados dos gráficos
    const dadosParticipantes = @json($evolucao_participantes ?? ['labels' => [], 'values' => []]);
    const dadosCategorias = @json($participantes_categoria ?? ['labels' => [], 'values' => []]);

    // Variáveis para armazenar os gráficos
    let participantesChart = null;
    let categoriasChart = null;

    // Função para criar ou atualizar gráfico
    function initParticipantesChart() {
        const canvas = document.getElementById('participantesChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Destruir gráfico anterior se existir
        if (participantesChart) {
            participantesChart.destroy();
        }
        
        participantesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dadosParticipantes.labels || ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Participantes',
                    data: dadosParticipantes.values || [0, 0, 0, 0, 0, 0],
                    borderColor: '#007BFF',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0 // Desabilita animação
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function initCategoriasChart() {
        const canvas = document.getElementById('categoriasChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Destruir gráfico anterior se existir
        if (categoriasChart) {
            categoriasChart.destroy();
        }
        
        categoriasChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: dadosCategorias.labels || [],
                datasets: [{
                    data: dadosCategorias.values || [],
                    backgroundColor: [
                        '#007BFF',
                        '#28A745',
                        '#FFC107',
                        '#DC3545',
                        '#6C757D'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0 // Desabilita animação
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Inicializar gráficos apenas se não for mobile
    if (window.innerWidth > 768) {
        initParticipantesChart();
        initCategoriasChart();
    }

    // Prevenir loop infinito em redimensionamento
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (participantesChart) {
                participantesChart.resize();
            }
            if (categoriasChart) {
                categoriasChart.resize();
            }
        }, 250);
    });
});
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'Novo Projeto')
@section('page-title', 'Novo Projeto')

@section('content')
<div class="container-fluid">
    <form action="{{ route('projetos.store') }}" method="POST">
        @csrf
        
        <!-- Dados Básicos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Dados Básicos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nome do Projeto *</label>
                        <input type="text" name="nome_projeto" class="form-control" required maxlength="250">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="1">Esportes</option>
                            <option value="2">Educação</option>
                            <option value="3">Cultura</option>
                            <option value="4">Saúde</option>
                            <option value="5">Tecnologia</option>
                            <option value="6">Meio Ambiente</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao_projeto" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Objetivos</label>
                    <textarea name="objetivos_projeto" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <!-- Período e Vagas -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Período e Vagas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data Início</label>
                        <input type="date" name="data_inicio" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data Fim</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Vagas Disponíveis *</label>
                        <input type="number" name="vagas_disponiveis" class="form-control" value="20" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Idade Mínima</label>
                        <input type="number" name="idade_minima" class="form-control" min="0" value="10">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Idade Máxima</label>
                        <input type="number" name="idade_maxima" class="form-control" min="0" value="18">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_projeto" class="form-select">
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                            <option value="Em Planejamento">Em Planejamento</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Localização -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Localização</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Endereço/Local</label>
                        <input type="text" name="local_projeto" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade_projeto" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="bairro_projeto" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Horário</label>
                        <input type="text" name="horario_inicio" class="form-control" placeholder="Ex: 14:00">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('projetos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Projeto
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

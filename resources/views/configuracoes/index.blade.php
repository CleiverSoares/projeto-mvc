@extends('layouts.app')

@section('title', 'Configurações')
@section('page-title', 'Configurações do Sistema')

@section('content')
<div class="container-fluid">
    <form action="{{ route('configuracoes.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Configurações Gerais -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Configurações Gerais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome da Organização</label>
                        <input type="text" name="nome_organizacao" class="form-control" value="Projeto Doar">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CNPJ</label>
                        <input type="text" name="cnpj" class="form-control" placeholder="00.000.000/0000-00">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Principal</label>
                        <input type="email" name="email_principal" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone Principal</label>
                        <input type="text" name="telefone_principal" class="form-control">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Endereço Completo</label>
                    <textarea name="endereco_organizacao" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <!-- Configurações de Relatórios -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Relatórios</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo para Relatórios</label>
                        <input type="file" name="logo_relatorios" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo de Relatório Padrão</label>
                        <select name="modelo_relatorio" class="form-select">
                            <option value="padrao">Padrão</option>
                            <option value="completo">Completo</option>
                            <option value="simples">Simples</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="mostrar_foto" class="form-check-input" id="mostrar_foto" checked>
                    <label class="form-check-label" for="mostrar_foto">Mostrar fotos nos relatórios</label>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="mostrar_endereco" class="form-check-input" id="mostrar_endereco" checked>
                    <label class="form-check-label" for="mostrar_endereco">Mostrar endereço nos relatórios</label>
                </div>
            </div>
        </div>

        <!-- Configurações de Notificações -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Notificações</h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="notificar_cadastro" class="form-check-input" id="notificar_cadastro">
                    <label class="form-check-label" for="notificar_cadastro">Notificar novos cadastros</label>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="notificar_eventos" class="form-check-input" id="notificar_eventos">
                    <label class="form-check-label" for="notificar_eventos">Notificar eventos próximos</label>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="notificar_doacoes" class="form-check-input" id="notificar_doacoes">
                    <label class="form-check-label" for="notificar_doacoes">Notificar doações recebidas</label>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Salvar Configurações
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

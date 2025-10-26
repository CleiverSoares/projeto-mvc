@extends('layouts.app')

@section('title', 'Detalhes da Doação')
@section('page-title', 'Detalhes da Doação')

@section('content')
<div class="container-fluid">
    @if($doacao)
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Doação</h5>
                <span class="badge bg-light text-dark">{{ $doacao->status_doacao }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Doador:</strong><br>
                        {{ $doacao->nome_doador }}
                    </div>
                    <div class="col-md-6">
                        <strong>Data:</strong><br>
                        {{ $doacao->data_doacao ? $doacao->data_doacao->format('d/m/Y') : '-' }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tipo:</strong><br>
                        {{ $doacao->tipo_doacao }}
                    </div>
                    <div class="col-md-6">
                        <strong>Valor:</strong><br>
                        <h4 class="text-success">R$ {{ number_format($doacao->valor_doacao, 2, ',', '.') }}</h4>
                    </div>
                </div>
                
                @if($doacao->forma_pagamento)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Forma de Pagamento:</strong><br>
                            {{ $doacao->forma_pagamento }}
                        </div>
                    </div>
                @endif
                
                @if($doacao->observacoes)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Observações:</strong><br>
                            <p>{{ $doacao->observacoes }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('doacoes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Doação não encontrada
        </div>
    @endif
</div>
@endsection

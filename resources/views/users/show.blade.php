@extends('layouts.app')

@section('title', 'Detalhes do Usuário')
@section('page-title', 'Detalhes do Usuário')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informações do Usuário</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-4">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Nome:</strong><br>
                                {{ $user->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong><br>
                                {{ $user->email }}
                            </div>
                            <div class="mb-3">
                                <strong>Telefone:</strong><br>
                                {{ $user->phone ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Perfil:</strong><br>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Administrador</span>
                                @elseif($user->role === 'gestor')
                                    <span class="badge bg-warning">Gestor</span>
                                @else
                                    <span class="badge bg-secondary">Usuário</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>Data de Cadastro:</strong><br>
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="mb-3">
                                <strong>Última Atualização:</strong><br>
                                {{ $user->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($user->id === auth()->id())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Esta é sua conta. Você não pode excluir seu próprio usuário.
                </div>
            @endif
        </div>
    </div>
    
    <div class="d-flex gap-2">
        @if($user->id === auth()->id())
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar Perfil
            </a>
        @else
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir este usuário?')">
                    <i class="fas fa-trash me-2"></i>Excluir
                </button>
            </form>
        @endif
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>
</div>
@endsection


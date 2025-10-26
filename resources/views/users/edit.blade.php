@extends('layouts.app')

@section('title', 'Editar Usuário')
@section('page-title', 'Editar Usuário')

@section('content')
<div class="container-fluid">
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editando: {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto de Perfil</label>
                        @if($user->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto atual" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nova Senha (deixe em branco para não alterar)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perfil *</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="gestor" {{ old('role', $user->role) === 'gestor' ? 'selected' : '' }}>Gestor</option>
                            <option value="usuario" {{ old('role', $user->role) === 'usuario' ? 'selected' : '' }}>Usuário</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


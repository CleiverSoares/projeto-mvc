@extends('layouts.app')

@section('title', 'Novo Usuário')
@section('page-title', 'Novo Usuário')

@section('content')
<div class="container-fluid">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Cadastrar Novo Usuário</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto de Perfil</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Senha *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar Senha *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perfil *</label>
                        <select name="role" class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="gestor" {{ old('role') === 'gestor' ? 'selected' : '' }}>Gestor</option>
                            <option value="usuario" {{ old('role') === 'usuario' ? 'selected' : '' }}>Usuário</option>
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
                        <i class="fas fa-save me-2"></i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


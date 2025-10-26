@extends('layouts.app')

@section('title', 'Editar Pessoa')
@section('page-title', 'Editar Pessoa')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pessoas.update', $pessoa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Dados Pessoais Básicos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome_pessoa" class="form-control" value="{{ old('nome_pessoa', $pessoa->nome_pessoa) }}" required maxlength="250">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">CPF *</label>
                        <input type="text" name="cpf_pessoa" class="form-control" value="{{ old('cpf_pessoa', $pessoa->cpf_pessoa) }}" required maxlength="14">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">RG</label>
                        <input type="text" name="rg_pessoa" class="form-control" value="{{ old('rg_pessoa', $pessoa->rg_pessoa) }}" maxlength="20">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data de Nascimento *</label>
                        <input type="date" name="data_nasc_pessoa" class="form-control" value="{{ old('data_nasc_pessoa', $pessoa->data_nasc_pessoa) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sexo *</label>
                        <select name="sexo_pessoa" class="form-select" required>
                            <option value="M" {{ $pessoa->sexo_pessoa == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $pessoa->sexo_pessoa == 'F' ? 'selected' : '' }}>Feminino</option>
                            <option value="Outro" {{ $pessoa->sexo_pessoa == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estado Civil</label>
                        <select name="estado_civil" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Solteiro" {{ $pessoa->estado_civil == 'Solteiro' ? 'selected' : '' }}>Solteiro</option>
                            <option value="Casado" {{ $pessoa->estado_civil == 'Casado' ? 'selected' : '' }}>Casado</option>
                            <option value="Divorciado" {{ $pessoa->estado_civil == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                            <option value="Viúvo" {{ $pessoa->estado_civil == 'Viúvo' ? 'selected' : '' }}>Viúvo</option>
                            <option value="União Estável" {{ $pessoa->estado_civil == 'União Estável' ? 'selected' : '' }}>União Estável</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cor/Raça</label>
                        <select name="cor_raca" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Branca" {{ $pessoa->cor_raca == 'Branca' ? 'selected' : '' }}>Branca</option>
                            <option value="Preta" {{ $pessoa->cor_raca == 'Preta' ? 'selected' : '' }}>Preta</option>
                            <option value="Parda" {{ $pessoa->cor_raca == 'Parda' ? 'selected' : '' }}>Parda</option>
                            <option value="Amarela" {{ $pessoa->cor_raca == 'Amarela' ? 'selected' : '' }}>Amarela</option>
                            <option value="Indígena" {{ $pessoa->cor_raca == 'Indígena' ? 'selected' : '' }}>Indígena</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nacionalidade</label>
                        <input type="text" name="nacionalidade" class="form-control" value="{{ old('nacionalidade', $pessoa->nacionalidade ?? 'Brasileira') }}" maxlength="50">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Naturalidade</label>
                        <input type="text" name="naturalidade" class="form-control" value="{{ old('naturalidade', $pessoa->naturalidade) }}" maxlength="100">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contatos -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contatos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telefone *</label>
                        <input type="text" name="telefone_pessoa" class="form-control" value="{{ old('telefone_pessoa', $pessoa->telefone_pessoa) }}" required maxlength="20">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email_pessoa" class="form-control" value="{{ old('email_pessoa', $pessoa->email_pessoa) }}" required maxlength="250">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telefone Emergência</label>
                        <input type="text" name="telefone_emergencia" class="form-control" value="{{ old('telefone_emergencia', $pessoa->telefone_emergencia) }}" maxlength="20">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Contato de Emergência</label>
                        <input type="text" name="contato_emergencia_nome" class="form-control" value="{{ old('contato_emergencia_nome', $pessoa->contato_emergencia_nome) }}" maxlength="250">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Parentesco do Contato</label>
                        <input type="text" name="parentesco_emergencia" class="form-control" value="{{ old('parentesco_emergencia', $pessoa->parentesco_emergencia) }}" maxlength="50">
                    </div>
                </div>
            </div>
        </div>

        <!-- Endereço -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep_pessoa" class="form-control" value="{{ old('cep_pessoa', $pessoa->cep_pessoa) }}" maxlength="9">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="endereco_pessoa" class="form-control" value="{{ old('endereco_pessoa', $pessoa->endereco_pessoa) }}" maxlength="250">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">Nº</label>
                        <input type="text" name="numero_endereco" class="form-control" value="{{ old('numero_endereco', $pessoa->numero_endereco) }}" maxlength="10">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Complemento</label>
                        <input type="text" name="complemento_endereco" class="form-control" value="{{ old('complemento_endereco', $pessoa->complemento_endereco) }}" maxlength="100">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="bairro_pessoa" class="form-control" value="{{ old('bairro_pessoa', $pessoa->bairro_pessoa) }}" maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade_pessoa" class="form-control" value="{{ old('cidade_pessoa', $pessoa->cidade_pessoa) }}" maxlength="100">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" name="estado_pessoa" class="form-control" value="{{ old('estado_pessoa', $pessoa->estado_pessoa) }}" maxlength="2">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">País</label>
                        <input type="text" name="pais_pessoa" class="form-control" value="{{ old('pais_pessoa', $pessoa->pais_pessoa ?? 'Brasil') }}" maxlength="50">
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados Socioeconômicos -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Dados Socioeconômicos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Renda Familiar</label>
                        <input type="number" name="renda_familiar" class="form-control" value="{{ old('renda_familiar', $pessoa->renda_familiar) }}" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Profissão</label>
                        <input type="text" name="profissao_pessoa" class="form-control" value="{{ old('profissao_pessoa', $pessoa->profissao_pessoa) }}" maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Escolaridade</label>
                        <select name="escolaridade" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Fundamental" {{ $pessoa->escolaridade == 'Fundamental' ? 'selected' : '' }}>Fundamental</option>
                            <option value="Médio" {{ $pessoa->escolaridade == 'Médio' ? 'selected' : '' }}>Médio</option>
                            <option value="Superior" {{ $pessoa->escolaridade == 'Superior' ? 'selected' : '' }}>Superior</option>
                            <option value="Pós-graduação" {{ $pessoa->escolaridade == 'Pós-graduação' ? 'selected' : '' }}>Pós-graduação</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Situação de Trabalho</label>
                        <select name="situacao_trabalho" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Empregado" {{ $pessoa->situacao_trabalho == 'Empregado' ? 'selected' : '' }}>Empregado</option>
                            <option value="Desempregado" {{ $pessoa->situacao_trabalho == 'Desempregado' ? 'selected' : '' }}>Desempregado</option>
                            <option value="Aposentado" {{ $pessoa->situacao_trabalho == 'Aposentado' ? 'selected' : '' }}>Aposentado</option>
                            <option value="Estudante" {{ $pessoa->situacao_trabalho == 'Estudante' ? 'selected' : '' }}>Estudante</option>
                            <option value="Autônomo" {{ $pessoa->situacao_trabalho == 'Autônomo' ? 'selected' : '' }}>Autônomo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados de Saúde -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Dados de Saúde</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="possui_deficiencia" class="form-check-input" value="1" {{ $pessoa->possui_deficiencia ? 'checked' : '' }}>
                            <label class="form-check-label">Possui Deficiência</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="plano_saude" class="form-check-input" value="1" {{ $pessoa->plano_saude ? 'checked' : '' }}>
                            <label class="form-check-label">Possui Plano de Saúde</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tipo Sanguíneo</label>
                        <select name="tipo_sangue" class="form-select">
                            <option value="">Selecione</option>
                            <option value="A+" {{ $pessoa->tipo_sangue == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $pessoa->tipo_sangue == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $pessoa->tipo_sangue == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $pessoa->tipo_sangue == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ $pessoa->tipo_sangue == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $pessoa->tipo_sangue == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ $pessoa->tipo_sangue == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $pessoa->tipo_sangue == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Deficiência</label>
                        <textarea name="tipo_deficiencia" class="form-control" rows="2">{{ old('tipo_deficiencia', $pessoa->tipo_deficiencia) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Medicamentos em Uso</label>
                        <textarea name="medicamentos_uso" class="form-control" rows="2">{{ old('medicamentos_uso', $pessoa->medicamentos_uso) }}</textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alergias</label>
                        <textarea name="alergias" class="form-control" rows="2">{{ old('alergias', $pessoa->alergias) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados do Projeto -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-project-diagram me-2"></i>Dados do Projeto</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data de Ingresso</label>
                        <input type="date" name="data_ingresso_projeto" class="form-control" value="{{ old('data_ingresso_projeto', $pessoa->data_ingresso_projeto) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status de Participação</label>
                        <select name="status_participacao" class="form-select">
                            <option value="Ativo" {{ $pessoa->status_participacao == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ $pessoa->status_participacao == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="Suspenso" {{ $pessoa->status_participacao == 'Suspenso' ? 'selected' : '' }}>Suspenso</option>
                            <option value="Egresso" {{ $pessoa->status_participacao == 'Egresso' ? 'selected' : '' }}>Egresso</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categorias</label>
                        <select name="categorias[]" class="form-select" multiple>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $pessoa->categorias->contains($categoria->id) ? 'selected' : '' }}>{{ $categoria->nome_categoria }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Mantenha Ctrl pressionado para selecionar múltiplas</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observações</label>
                        <textarea name="observacoes_pessoa" class="form-control" rows="3">{{ old('observacoes_pessoa', $pessoa->observacoes_pessoa) }}</textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="aceita_termos" class="form-check-input" value="1" {{ $pessoa->aceita_termos ? 'checked' : '' }}>
                            <label class="form-check-label">Aceita os termos e condições</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="autoriza_imagem" class="form-check-input" value="1" {{ $pessoa->autoriza_imagem ? 'checked' : '' }}>
                            <label class="form-check-label">Autoriza uso de imagem</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arquivos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Anexos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="foto_pessoa" class="form-control" accept="image/*">
                        @if($pessoa->foto_pessoa)
                            <small class="text-muted">Foto atual: {{ $pessoa->foto_pessoa }}</small>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">CPF (documento)</label>
                        <input type="file" name="documento_cpf" class="form-control" accept=".pdf,.jpg,.png">
                        @if($pessoa->documento_cpf)
                            <small class="text-muted">Documento: {{ $pessoa->documento_cpf }}</small>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RG (documento)</label>
                        <input type="file" name="documento_rg" class="form-control" accept=".pdf,.jpg,.png">
                        @if($pessoa->documento_rg)
                            <small class="text-muted">Documento: {{ $pessoa->documento_rg }}</small>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Comprovante de Residência</label>
                        <input type="file" name="comprovante_residencia" class="form-control" accept=".pdf,.jpg,.png">
                        @if($pessoa->comprovante_residencia)
                            <small class="text-muted">Documento: {{ $pessoa->comprovante_residencia }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pessoas.show', $pessoa->id) }}" class="btn btn-secondary">
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

<style>
    .card-header h5 {
        margin: 0;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Cadastrar Nova Pessoa')
@section('page-title', 'Cadastrar Nova Pessoa')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pessoas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Dados Pessoais Básicos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome_pessoa" class="form-control" required maxlength="250">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">CPF *</label>
                        <input type="text" name="cpf_pessoa" class="form-control" required maxlength="14">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">RG</label>
                        <input type="text" name="rg_pessoa" class="form-control" maxlength="20">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Data de Nascimento *</label>
                        <input type="date" name="data_nasc_pessoa" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sexo *</label>
                        <select name="sexo_pessoa" class="form-select" required>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estado Civil</label>
                        <select name="estado_civil" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Solteiro">Solteiro</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viúvo">Viúvo</option>
                            <option value="União Estável">União Estável</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cor/Raça</label>
                        <select name="cor_raca" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Branca">Branca</option>
                            <option value="Preta">Preta</option>
                            <option value="Parda">Parda</option>
                            <option value="Amarela">Amarela</option>
                            <option value="Indígena">Indígena</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nacionalidade</label>
                        <input type="text" name="nacionalidade" class="form-control" value="Brasileira" maxlength="50">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Naturalidade</label>
                        <input type="text" name="naturalidade" class="form-control" maxlength="100">
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
                        <input type="text" name="telefone_pessoa" class="form-control" required maxlength="20">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email_pessoa" class="form-control" required maxlength="250">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telefone Emergência</label>
                        <input type="text" name="telefone_emergencia" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Contato de Emergência</label>
                        <input type="text" name="contato_emergencia_nome" class="form-control" maxlength="250">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Parentesco do Contato</label>
                        <input type="text" name="parentesco_emergencia" class="form-control" maxlength="50">
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
                        <input type="text" name="cep_pessoa" class="form-control" maxlength="9">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="endereco_pessoa" class="form-control" maxlength="250">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">Nº</label>
                        <input type="text" name="numero_endereco" class="form-control" maxlength="10">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Complemento</label>
                        <input type="text" name="complemento_endereco" class="form-control" maxlength="100">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="bairro_pessoa" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade_pessoa" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" name="estado_pessoa" class="form-control" maxlength="2">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">País</label>
                        <input type="text" name="pais_pessoa" class="form-control" value="Brasil" maxlength="50">
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
                        <input type="number" name="renda_familiar" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Profissão</label>
                        <input type="text" name="profissao_pessoa" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Escolaridade</label>
                        <select name="escolaridade" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Fundamental">Fundamental</option>
                            <option value="Médio">Médio</option>
                            <option value="Superior">Superior</option>
                            <option value="Pós-graduação">Pós-graduação</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Situação de Trabalho</label>
                        <select name="situacao_trabalho" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Empregado">Empregado</option>
                            <option value="Desempregado">Desempregado</option>
                            <option value="Aposentado">Aposentado</option>
                            <option value="Estudante">Estudante</option>
                            <option value="Autônomo">Autônomo</option>
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
                            <input type="checkbox" name="possui_deficiencia" class="form-check-input" value="1">
                            <label class="form-check-label">Possui Deficiência</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="plano_saude" class="form-check-input" value="1">
                            <label class="form-check-label">Possui Plano de Saúde</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tipo Sanguíneo</label>
                        <select name="tipo_sangue" class="form-select">
                            <option value="">Selecione</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Deficiência</label>
                        <textarea name="tipo_deficiencia" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Medicamentos em Uso</label>
                        <textarea name="medicamentos_uso" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alergias</label>
                        <textarea name="alergias" class="form-control" rows="2"></textarea>
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
                        <input type="date" name="data_ingresso_projeto" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status de Participação</label>
                        <select name="status_participacao" class="form-select">
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                            <option value="Suspenso">Suspenso</option>
                            <option value="Egresso">Egresso</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categorias</label>
                        <select name="categorias[]" class="form-select" multiple>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Mantenha Ctrl pressionado para selecionar múltiplas</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observações</label>
                        <textarea name="observacoes_pessoa" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="aceita_termos" class="form-check-input" value="1" required>
                            <label class="form-check-label">Aceita os termos e condições *</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="autoriza_imagem" class="form-check-input" value="1">
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
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">CPF (documento)</label>
                        <input type="file" name="documento_cpf" class="form-control" accept=".pdf,.jpg,.png">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RG (documento)</label>
                        <input type="file" name="documento_rg" class="form-control" accept=".pdf,.jpg,.png">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Comprovante de Residência</label>
                        <input type="file" name="comprovante_residencia" class="form-control" accept=".pdf,.jpg,.png">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Cadastro
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

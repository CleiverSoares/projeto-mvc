<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_pessoa')->unique();
            
            // Dados Pessoais Básicos
            $table->string('nome_pessoa', 250);
            $table->string('cpf_pessoa', 14)->unique();
            $table->string('rg_pessoa', 20)->nullable();
            $table->date('data_nasc_pessoa');
            $table->enum('sexo_pessoa', ['M', 'F', 'Outro'])->default('M');
            $table->enum('estado_civil', ['Solteiro', 'Casado', 'Divorciado', 'Viúvo', 'União Estável'])->nullable();
            $table->enum('cor_raca', ['Branca', 'Preta', 'Parda', 'Amarela', 'Indígena'])->nullable();
            $table->string('nacionalidade', 50)->default('Brasileira');
            $table->string('naturalidade', 100)->nullable();
            
            // Contatos
            $table->string('telefone_pessoa', 20);
            $table->string('email_pessoa', 250)->unique();
            $table->string('telefone_emergencia', 20)->nullable();
            $table->string('contato_emergencia_nome', 250)->nullable();
            $table->string('parentesco_emergencia', 50)->nullable();
            
            // Endereço
            $table->string('cep_pessoa', 9)->nullable();
            $table->string('endereco_pessoa', 250)->nullable();
            $table->string('numero_endereco', 10)->nullable();
            $table->string('complemento_endereco', 100)->nullable();
            $table->string('bairro_pessoa', 100)->nullable();
            $table->string('cidade_pessoa', 100)->nullable();
            $table->string('estado_pessoa', 2)->nullable();
            $table->string('pais_pessoa', 50)->default('Brasil');
            
            // Dados Socioeconômicos
            $table->decimal('renda_familiar', 10, 2)->nullable();
            $table->string('profissao_pessoa', 100)->nullable();
            $table->enum('escolaridade', ['Fundamental', 'Médio', 'Superior', 'Pós-graduação'])->nullable();
            $table->enum('situacao_trabalho', ['Empregado', 'Desempregado', 'Aposentado', 'Estudante', 'Autônomo'])->nullable();
            
            // Dados de Saúde
            $table->boolean('possui_deficiencia')->default(false);
            $table->text('tipo_deficiencia')->nullable();
            $table->text('medicamentos_uso')->nullable();
            $table->text('alergias')->nullable();
            $table->boolean('plano_saude')->default(false);
            $table->enum('tipo_sangue', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            
            // Dados do Projeto
            $table->date('data_ingresso_projeto')->nullable();
            $table->enum('status_participacao', ['Ativo', 'Inativo', 'Suspenso', 'Egresso'])->default('Ativo');
            $table->text('observacoes_pessoa')->nullable();
            $table->boolean('aceita_termos')->default(false);
            $table->boolean('autoriza_imagem')->default(false);
            
            // Arquivos
            $table->string('foto_pessoa')->nullable();
            $table->string('documento_cpf')->nullable();
            $table->string('documento_rg')->nullable();
            $table->string('comprovante_residencia')->nullable();
            
            // Controle
            $table->boolean('ativo')->default(true);
            $table->timestamp('ultimo_acesso')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['nome_pessoa']);
            $table->index(['cpf_pessoa']);
            $table->index(['email_pessoa']);
            $table->index(['status_participacao']);
            $table->index(['data_ingresso_projeto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};

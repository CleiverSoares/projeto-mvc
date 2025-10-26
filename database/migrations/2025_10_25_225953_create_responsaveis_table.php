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
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->uuid('uuid_responsavel')->unique();
            
            // Dados do Responsável
            $table->string('nome_responsavel', 250);
            $table->string('cpf_responsavel', 14)->unique();
            $table->string('rg_responsavel', 20)->nullable();
            $table->string('telefone_responsavel', 20);
            $table->string('email_responsavel', 250)->nullable();
            
            // Relacionamento
            $table->enum('parentesco', ['Pai', 'Mae', 'Avo_Masculino', 'Avo_Feminino', 'Tio', 'Tia', 'Tutor_Legal', 'Outro'])->default('Pai');
            $table->string('outro_parentesco', 100)->nullable(); // Se parentesco for "Outro"
            
            // Dados Socioeconômicos
            $table->string('profissao_responsavel', 100)->nullable();
            $table->decimal('renda_responsavel', 10, 2)->nullable();
            $table->string('empresa_responsavel', 250)->nullable();
            
            // Endereço (pode ser diferente da pessoa)
            $table->string('cep_responsavel', 9)->nullable();
            $table->string('endereco_responsavel', 250)->nullable();
            $table->string('numero_responsavel', 10)->nullable();
            $table->string('complemento_responsavel', 100)->nullable();
            $table->string('bairro_responsavel', 100)->nullable();
            $table->string('cidade_responsavel', 100)->nullable();
            $table->string('estado_responsavel', 2)->nullable();
            
            // Controle
            $table->text('observacoes_responsavel')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['pessoa_id']);
            $table->index(['nome_responsavel']);
            $table->index(['cpf_responsavel']);
            $table->index(['parentesco']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};

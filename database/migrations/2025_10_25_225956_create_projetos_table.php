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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->uuid('uuid_projeto')->unique();
            
            // Dados do Projeto
            $table->string('nome_projeto', 250);
            $table->text('descricao_projeto');
            $table->text('objetivos_projeto')->nullable();
            $table->text('metodologia_projeto')->nullable();
            
            // Período e Vagas
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->integer('vagas_disponiveis')->default(0);
            $table->integer('vagas_preenchidas')->default(0);
            
            // Requisitos
            $table->integer('idade_minima')->nullable();
            $table->integer('idade_maxima')->nullable();
            $table->text('requisitos_projeto')->nullable();
            $table->text('documentos_necessarios')->nullable();
            
            // Localização
            $table->string('local_projeto', 250)->nullable();
            $table->string('endereco_projeto', 250)->nullable();
            $table->string('bairro_projeto', 100)->nullable();
            $table->string('cidade_projeto', 100)->nullable();
            
            // Horários
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fim')->nullable();
            $table->json('dias_semana')->nullable(); // ['segunda', 'terça', 'quarta', 'quinta', 'sexta']
            
            // Financeiro
            $table->decimal('valor_mensalidade', 8, 2)->nullable();
            $table->boolean('gratuito')->default(true);
            $table->text('formas_pagamento')->nullable();
            
            // Controle
            $table->enum('status_projeto', ['Ativo', 'Inativo', 'Suspenso', 'Finalizado'])->default('Ativo');
            $table->text('observacoes_projeto')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['categoria_id']);
            $table->index(['nome_projeto']);
            $table->index(['status_projeto']);
            $table->index(['data_inicio']);
            $table->index(['data_fim']);
            $table->index(['ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};

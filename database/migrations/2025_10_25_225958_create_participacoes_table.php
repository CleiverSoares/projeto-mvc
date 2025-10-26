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
        Schema::create('participacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->foreignId('projeto_id')->constrained('projetos')->onDelete('cascade');
            $table->uuid('uuid_participacao')->unique();
            
            // Dados da Participação
            $table->date('data_inscricao');
            $table->enum('status_inscricao', ['Pendente', 'Aprovado', 'Rejeitado', 'Cancelado', 'Desistente'])->default('Pendente');
            $table->date('data_aprovacao')->nullable();
            $table->date('data_inicio_participacao')->nullable();
            $table->date('data_fim_participacao')->nullable();
            
            // Avaliação
            $table->text('motivo_rejeicao')->nullable();
            $table->text('motivo_cancelamento')->nullable();
            $table->text('observacoes_participacao')->nullable();
            
            // Controle de Presença
            $table->integer('total_presencas')->default(0);
            $table->integer('total_faltas')->default(0);
            $table->decimal('percentual_presenca', 5, 2)->default(0);
            
            // Pagamento
            $table->boolean('pagamento_em_dia')->default(true);
            $table->date('ultimo_pagamento')->nullable();
            $table->decimal('valor_pago', 8, 2)->default(0);
            
            // Controle
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['pessoa_id']);
            $table->index(['projeto_id']);
            $table->index(['status_inscricao']);
            $table->index(['data_inscricao']);
            $table->index(['data_aprovacao']);
            $table->index(['ativo']);
            
            // Evitar duplicatas
            $table->unique(['pessoa_id', 'projeto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participacoes');
    }
};

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
        Schema::create('doacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doador_id')->nullable()->constrained('pessoas')->onDelete('set null');
            $table->uuid('uuid_doacao')->unique();
            
            // Dados da Doação
            $table->enum('tipo_doacao', ['Dinheiro', 'Material', 'Serviço', 'Tempo', 'Outro'])->default('Dinheiro');
            $table->decimal('valor_doacao', 10, 2)->nullable();
            $table->text('descricao_doacao');
            $table->text('itens_doados')->nullable(); // Para doações materiais
            
            // Data e Status
            $table->date('data_doacao');
            $table->enum('status_doacao', ['Pendente', 'Confirmada', 'Cancelada', 'Rejeitada'])->default('Pendente');
            $table->date('data_confirmacao')->nullable();
            
            // Comprovante
            $table->string('comprovante_doacao')->nullable();
            $table->text('observacoes_doacao')->nullable();
            
            // Controle
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['doador_id']);
            $table->index(['tipo_doacao']);
            $table->index(['data_doacao']);
            $table->index(['status_doacao']);
            $table->index(['ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doacoes');
    }
};

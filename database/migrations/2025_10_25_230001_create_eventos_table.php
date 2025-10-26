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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->nullable()->constrained('projetos')->onDelete('set null');
            $table->uuid('uuid_evento')->unique();
            
            // Dados do Evento
            $table->string('nome_evento', 250);
            $table->text('descricao_evento')->nullable();
            $table->enum('tipo_evento', ['Esportivo', 'Cultural', 'Educativo', 'Social', 'Recreativo', 'Competitivo'])->default('Esportivo');
            
            // Data e Hora
            $table->datetime('data_evento');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            
            // Localização
            $table->string('local_evento', 250);
            $table->string('endereco_evento', 250)->nullable();
            $table->string('bairro_evento', 100)->nullable();
            $table->string('cidade_evento', 100)->nullable();
            $table->string('estado_evento', 2)->nullable();
            
            // Capacidade e Ingressos
            $table->integer('capacidade_evento')->nullable();
            $table->integer('vagas_disponiveis')->nullable();
            $table->decimal('valor_ingresso', 8, 2)->nullable();
            $table->boolean('gratuito')->default(true);
            
            // Organização
            $table->string('organizador_evento', 250)->nullable();
            $table->string('responsavel_evento', 250)->nullable();
            $table->string('telefone_contato', 20)->nullable();
            $table->string('email_contato', 250)->nullable();
            
            // Controle
            $table->enum('status_evento', ['Agendado', 'Confirmado', 'Em Andamento', 'Finalizado', 'Cancelado'])->default('Agendado');
            $table->text('observacoes_evento')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['projeto_id']);
            $table->index(['nome_evento']);
            $table->index(['tipo_evento']);
            $table->index(['data_evento']);
            $table->index(['status_evento']);
            $table->index(['ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

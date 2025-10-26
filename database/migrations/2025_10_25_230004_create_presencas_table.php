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
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->onDelete('cascade');
            $table->foreignId('projeto_id')->nullable()->constrained('projetos')->onDelete('cascade');
            $table->uuid('uuid_presenca')->unique();
            
            // Dados da Presença
            $table->date('data_presenca');
            $table->time('hora_chegada')->nullable();
            $table->time('hora_saida')->nullable();
            $table->enum('status_presenca', ['Presente', 'Falta', 'Falta Justificada', 'Atraso'])->default('Presente');
            
            // Observações
            $table->text('observacoes_presenca')->nullable();
            $table->text('justificativa_falta')->nullable();
            
            // Controle
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['pessoa_id']);
            $table->index(['evento_id']);
            $table->index(['projeto_id']);
            $table->index(['data_presenca']);
            $table->index(['status_presenca']);
            $table->index(['ativo']);
            
            // Evitar duplicatas
            $table->unique(['pessoa_id', 'evento_id', 'data_presenca']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};

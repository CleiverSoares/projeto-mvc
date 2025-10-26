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
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('chave_configuracao', 100)->unique();
            $table->text('valor_configuracao');
            $table->text('descricao_configuracao')->nullable();
            $table->enum('tipo_configuracao', ['texto', 'numero', 'booleano', 'json', 'arquivo'])->default('texto');
            $table->string('categoria_configuracao', 50)->default('geral');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['chave_configuracao']);
            $table->index(['categoria_configuracao']);
            $table->index(['ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};

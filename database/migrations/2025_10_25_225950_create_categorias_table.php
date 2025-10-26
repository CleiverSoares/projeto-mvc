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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome_categoria', 250);
            $table->text('descricao_categoria')->nullable();
            $table->string('cor_categoria', 7)->default('#007BFF'); // Código hexadecimal da cor
            $table->string('icone_categoria', 50)->nullable(); // Classe do ícone FontAwesome
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0); // Para ordenação
            $table->timestamps();
            
            // Índices
            $table->index(['nome_categoria']);
            $table->index(['ativo']);
            $table->index(['ordem']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};

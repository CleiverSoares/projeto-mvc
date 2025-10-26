<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar categorias
        $categoria1 = \App\Models\Categoria::create([
            'nome_categoria' => 'Crianças e Adolescentes',
            'cor_categoria' => '#007BFF',
            'ativo' => true,
            'descricao_categoria' => 'Projetos voltados para crianças e adolescentes'
        ]);

        $categoria2 = \App\Models\Categoria::create([
            'nome_categoria' => 'Pessoas com Deficiência',
            'cor_categoria' => '#28a745',
            'ativo' => true,
            'descricao_categoria' => 'Projetos de inclusão social'
        ]);

        // Criar projetos
        \App\Models\Projeto::create([
            'nome_projeto' => 'Projeto Esperança',
            'categoria_id' => $categoria1->id,
            'data_inicio' => now(),
            'data_fim' => now()->addMonths(6),
            'vagas_preenchidas' => 0,
            'vagas_disponiveis' => 50,
            'status_projeto' => 'Ativo',
            'descricao_projeto' => 'Projeto voltado para o desenvolvimento de habilidades em crianças carentes'
        ]);

        \App\Models\Projeto::create([
            'nome_projeto' => 'Projeto Inclusão',
            'categoria_id' => $categoria2->id,
            'data_inicio' => now(),
            'data_fim' => now()->addMonths(12),
            'vagas_preenchidas' => 0,
            'vagas_disponiveis' => 30,
            'status_projeto' => 'Ativo',
            'descricao_projeto' => 'Projeto de inclusão social e profissional'
        ]);

        // Criar usuário admin
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@projetodoar.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );
        
        // Criar uma pessoa de teste
        \App\Models\Pessoa::firstOrCreate(
            ['cpf_pessoa' => '123.456.789-00'],
            [
                'uuid_pessoa' => \Str::uuid(),
            'nome_pessoa' => 'João Silva',
            'data_nasc_pessoa' => now()->subYears(15)->format('Y-m-d'),
            'sexo_pessoa' => 'M',
            'cpf_pessoa' => '123.456.789-00',
            'rg_pessoa' => '12.345.678',
            'email_pessoa' => 'joao@exemplo.com',
            'telefone_pessoa' => '(11) 98765-4321',
            'cep_pessoa' => '01310-100',
            'endereco_pessoa' => 'Avenida Paulista',
            'numero_endereco' => '1000',
            'bairro_pessoa' => 'Bela Vista',
            'cidade_pessoa' => 'São Paulo',
            'estado_pessoa' => 'SP',
            'ativo' => true,
        ]);
    }
}

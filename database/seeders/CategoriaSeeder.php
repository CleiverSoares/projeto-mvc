<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nome_categoria' => 'Esportes',
                'descricao_categoria' => 'Atividades esportivas e físicas',
                'cor_categoria' => '#007BFF',
                'icone_categoria' => 'fas fa-running',
                'ordem' => 1,
            ],
            [
                'nome_categoria' => 'Educação',
                'descricao_categoria' => 'Cursos e atividades educacionais',
                'cor_categoria' => '#28A745',
                'icone_categoria' => 'fas fa-graduation-cap',
                'ordem' => 2,
            ],
            [
                'nome_categoria' => 'Cultura',
                'descricao_categoria' => 'Atividades culturais e artísticas',
                'cor_categoria' => '#FFC107',
                'icone_categoria' => 'fas fa-palette',
                'ordem' => 3,
            ],
            [
                'nome_categoria' => 'Saúde',
                'descricao_categoria' => 'Programas de saúde e bem-estar',
                'cor_categoria' => '#DC3545',
                'icone_categoria' => 'fas fa-heartbeat',
                'ordem' => 4,
            ],
            [
                'nome_categoria' => 'Tecnologia',
                'descricao_categoria' => 'Cursos de informática e tecnologia',
                'cor_categoria' => '#6F42C1',
                'icone_categoria' => 'fas fa-laptop-code',
                'ordem' => 5,
            ],
            [
                'nome_categoria' => 'Meio Ambiente',
                'descricao_categoria' => 'Projetos de sustentabilidade e ecologia',
                'cor_categoria' => '#20C997',
                'icone_categoria' => 'fas fa-leaf',
                'ordem' => 6,
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}

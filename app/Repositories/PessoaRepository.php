<?php

namespace App\Repositories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PessoaRepository extends BaseRepository
{
    public function __construct(Pessoa $model)
    {
        parent::__construct($model);
    }

    /**
     * Buscar pessoas com filtros avançados
     */
    public function buscarComFiltros(array $filtros = []): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Filtro por nome
        if (isset($filtros['nome']) && !empty($filtros['nome'])) {
            $query->where('nome_pessoa', 'like', '%' . $filtros['nome'] . '%');
        }

        // Filtro por CPF
        if (isset($filtros['cpf']) && !empty($filtros['cpf'])) {
            $query->where('cpf_pessoa', 'like', '%' . $filtros['cpf'] . '%');
        }

        // Filtro por cidade
        if (isset($filtros['cidade']) && !empty($filtros['cidade'])) {
            $query->where('cidade_pessoa', 'like', '%' . $filtros['cidade'] . '%');
        }

        // Filtro por bairro
        if (isset($filtros['bairro']) && !empty($filtros['bairro'])) {
            $query->where('bairro_pessoa', 'like', '%' . $filtros['bairro'] . '%');
        }

        // Filtro por status
        if (isset($filtros['status']) && !empty($filtros['status'])) {
            $query->where('status_participacao', $filtros['status']);
        }

        // Filtro por idade
        if (isset($filtros['idade_min']) && !empty($filtros['idade_min'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) >= ?', [$filtros['idade_min']]);
        }

        if (isset($filtros['idade_max']) && !empty($filtros['idade_max'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) <= ?', [$filtros['idade_max']]);
        }

        // Filtro por categoria
        if (isset($filtros['categoria_id']) && !empty($filtros['categoria_id'])) {
            $query->whereHas('categorias', function ($q) use ($filtros) {
                $q->where('categoria_id', $filtros['categoria_id']);
            });
        }

        // Filtro por projeto
        if (isset($filtros['projeto_id']) && !empty($filtros['projeto_id'])) {
            $query->whereHas('participacoes', function ($q) use ($filtros) {
                $q->where('projeto_id', $filtros['projeto_id']);
            });
        }

        // Filtro por data de ingresso
        if (isset($filtros['data_inicio']) && !empty($filtros['data_inicio'])) {
            $query->where('data_ingresso_projeto', '>=', $filtros['data_inicio']);
        }

        if (isset($filtros['data_fim']) && !empty($filtros['data_fim'])) {
            $query->where('data_ingresso_projeto', '<=', $filtros['data_fim']);
        }

        // Ordenação
        $ordenacao = $filtros['ordenacao'] ?? 'nome_pessoa';
        $direcao = $filtros['direcao'] ?? 'asc';
        $query->orderBy($ordenacao, $direcao);

        // Paginação
        $perPage = $filtros['per_page'] ?? 15;
        return $query->with(['categorias', 'responsavel', 'participacoes.projeto'])->paginate($perPage);
    }

    /**
     * Estatísticas gerais
     */
    public function getEstatisticas(): array
    {
        return [
            'total_pessoas' => $this->model->count(),
            'pessoas_ativas' => $this->model->where('ativo', true)->count(),
            'menores_idade' => $this->model->whereRaw('TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 18')->count(),
            'com_responsavel' => $this->model->whereHas('responsavel')->count(),
            'por_status' => $this->model->selectRaw('status_participacao, COUNT(*) as total')
                ->groupBy('status_participacao')
                ->pluck('total', 'status_participacao')
                ->toArray(),
            'por_cidade' => $this->model->selectRaw('cidade_pessoa, COUNT(*) as total')
                ->whereNotNull('cidade_pessoa')
                ->groupBy('cidade_pessoa')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->pluck('total', 'cidade_pessoa')
                ->toArray(),
        ];
    }

    /**
     * Buscar pessoas por projeto
     */
    public function getPessoasPorProjeto(int $projetoId): Collection
    {
        return $this->model->whereHas('participacoes', function ($query) use ($projetoId) {
            $query->where('projeto_id', $projetoId);
        })->with(['participacoes' => function ($query) use ($projetoId) {
            $query->where('projeto_id', $projetoId);
        }])->get();
    }

    /**
     * Buscar pessoas com baixa frequência
     */
    public function getPessoasComBaixaFrequencia(float $percentualMinimo = 70.0): Collection
    {
        return $this->model->whereHas('presencas', function ($query) {
            $query->selectRaw('pessoa_id, 
                (COUNT(CASE WHEN status_presenca = "Presente" THEN 1 END) * 100.0 / COUNT(*)) as percentual')
                ->groupBy('pessoa_id')
                ->havingRaw('percentual < ?', [$percentualMinimo]);
        })->get();
    }
}

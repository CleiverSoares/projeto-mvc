<?php

namespace App\Http\Controllers;

use App\Services\PessoaService;
use App\Models\Pessoa;
use App\Models\Projeto;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Doacao;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    /**
     * Exibir dashboard principal
     */
    public function index(Request $request)
    {
        try {
            // Total de participantes
            $total_participantes = Pessoa::count();
            $participantes_mes = Pessoa::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->count();
            
            // Projetos ativos
            $projetos_ativos = Projeto::where('status_projeto', 'Ativo')->count();
            $novos_projetos = Projeto::whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)
                                     ->count();
            
            // Doações
            $total_doacoes = Doacao::sum('valor_doacao') ?? 0;
            $doacoes_mes = Doacao::whereMonth('data_doacao', now()->month)
                                  ->whereYear('data_doacao', now()->year)
                                  ->sum('valor_doacao') ?? 0;
            
            // Eventos
            $eventos_realizados = Evento::count();
            $eventos_mes = Evento::whereMonth('data_evento', now()->month)
                                 ->whereYear('data_evento', now()->year)
                                 ->count();
            
            // Dados para gráficos
            $evolucao_participantes = $this->getEvolucaoParticipantes();
            $participantes_categoria = $this->getParticipantesCategoria();
            
            return view('dashboard', compact(
                'total_participantes', 
                'participantes_mes',
                'projetos_ativos',
                'novos_projetos',
                'total_doacoes',
                'doacoes_mes',
                'eventos_realizados',
                'eventos_mes',
                'evolucao_participantes',
                'participantes_categoria'
            ));
        } catch (\Exception $e) {
            // Fallback
            $total_participantes = 0;
            $participantes_mes = 0;
            $projetos_ativos = 0;
            $novos_projetos = 0;
            $total_doacoes = 0;
            $doacoes_mes = 0;
            $eventos_realizados = 0;
            $eventos_mes = 0;
            $evolucao_participantes = ['labels' => [], 'values' => []];
            $participantes_categoria = ['labels' => [], 'values' => []];
            
            return view('dashboard', compact(
                'total_participantes', 
                'participantes_mes',
                'projetos_ativos',
                'novos_projetos',
                'total_doacoes',
                'doacoes_mes',
                'eventos_realizados',
                'eventos_mes',
                'evolucao_participantes',
                'participantes_categoria'
            ));
        }
    }
    
    /**
     * Obter evolução de participantes
     */
    private function getEvolucaoParticipantes(): array
    {
        $meses = [];
        $valores = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $data = now()->subMonths($i);
            $meses[] = $data->format('M');
            $valores[] = Pessoa::whereYear('created_at', $data->year)
                               ->whereMonth('created_at', $data->month)
                               ->count();
        }
        
        return [
            'labels' => $meses,
            'values' => $valores
        ];
    }
    
    /**
     * Obter participantes por categoria
     */
    private function getParticipantesCategoria(): array
    {
        $dados = DB::table('categoria_pessoa')
            ->join('categorias', 'categoria_pessoa.categoria_id', '=', 'categorias.id')
            ->select('categorias.nome_categoria', DB::raw('COUNT(*) as total'))
            ->groupBy('categorias.id', 'categorias.nome_categoria')
            ->get();
        
        $labels = [];
        $values = [];
        
        foreach ($dados as $item) {
            $labels[] = $item->nome_categoria;
            $values[] = $item->total;
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    /**
     * API para dados do dashboard
     */
    public function dados(Request $request): JsonResponse
    {
        try {
            $filtros = $request->only(['periodo', 'categoria_id', 'projeto_id']);
            
            $dados = [
                'estatisticas' => $this->getEstatisticasGerais($filtros),
                'graficos' => $this->getDadosGraficos($filtros),
                'tabelas' => $this->getDadosTabelas($filtros)
            ];

            return response()->json($dados);
        } catch (\Exception $e) {
            // Fallback simples em caso de erro
            $dados = [
                'estatisticas' => [
                    'total_pessoas' => 0,
                    'pessoas_ativas' => 0,
                    'total_projetos' => 0,
                    'projetos_ativos' => 0,
                    'total_eventos' => 0,
                    'eventos_mes' => 0,
                    'total_doacoes' => 0,
                    'valor_doacoes' => 0,
                    'menores_idade' => 0,
                    'com_responsavel' => 0,
                ],
                'graficos' => [
                    'pessoas_por_status' => [],
                    'pessoas_por_cidade' => [],
                    'pessoas_por_idade' => [],
                    'projetos_por_categoria' => [],
                    'doacoes_por_mes' => [],
                    'presencas_por_mes' => [],
                ],
                'tabelas' => [
                    'pessoas_recentes' => [],
                    'projetos_populares' => [],
                    'eventos_proximos' => [],
                    'doacoes_recentes' => [],
                ]
            ];

            return response()->json($dados);
        }
    }

    /**
     * Obter estatísticas gerais
     */
    private function getEstatisticasGerais(array $filtros = []): array
    {
        $queryPessoas = Pessoa::query();
        $queryProjetos = Projeto::query();
        $queryEventos = Evento::query();
        $queryDoacoes = Doacao::query();

        // Aplicar filtros de período
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodo($queryPessoas, $filtros['periodo'], 'data_ingresso_projeto');
            $this->aplicarFiltroPeriodo($queryProjetos, $filtros['periodo'], 'created_at');
            $this->aplicarFiltroPeriodo($queryEventos, $filtros['periodo'], 'data_evento');
            $this->aplicarFiltroPeriodo($queryDoacoes, $filtros['periodo'], 'data_doacao');
        }

        // Aplicar filtros de categoria
        if (isset($filtros['categoria_id'])) {
            $queryPessoas->whereHas('categorias', function ($q) use ($filtros) {
                $q->where('categoria_id', $filtros['categoria_id']);
            });
            $queryProjetos->where('categoria_id', $filtros['categoria_id']);
        }

        // Aplicar filtros de projeto
        if (isset($filtros['projeto_id'])) {
            $queryPessoas->whereHas('participacoes', function ($q) use ($filtros) {
                $q->where('projeto_id', $filtros['projeto_id']);
            });
        }

        return [
            'total_pessoas' => $queryPessoas->count(),
            'pessoas_ativas' => $queryPessoas->where('status_participacao', 'Ativo')->count(),
            'total_projetos' => $queryProjetos->count(),
            'projetos_ativos' => $queryProjetos->where('status_projeto', 'Ativo')->count(),
            'total_eventos' => $queryEventos->count(),
            'eventos_mes' => $queryEventos->whereMonth('data_evento', now()->month)->count(),
            'total_doacoes' => $queryDoacoes->count(),
            'valor_doacoes' => $queryDoacoes->sum('valor_doacao'),
            'menores_idade' => $queryPessoas->whereRaw('TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 18')->count(),
            'com_responsavel' => $queryPessoas->whereHas('responsavel')->count(),
        ];
    }

    /**
     * Obter dados para gráficos
     */
    private function getDadosGraficos(array $filtros = []): array
    {
        return [
            'pessoas_por_status' => $this->getPessoasPorStatus($filtros),
            'pessoas_por_cidade' => $this->getPessoasPorCidade($filtros),
            'pessoas_por_idade' => $this->getPessoasPorIdade($filtros),
            'projetos_por_categoria' => $this->getProjetosPorCategoria($filtros),
            'doacoes_por_mes' => $this->getDoacoesPorMes($filtros),
            'presencas_por_mes' => $this->getPresencasPorMes($filtros),
        ];
    }

    /**
     * Obter dados para tabelas
     */
    private function getDadosTabelas(array $filtros = []): array
    {
        return [
            'pessoas_recentes' => $this->getPessoasRecentes($filtros),
            'projetos_populares' => $this->getProjetosPopulares($filtros),
            'eventos_proximos' => $this->getEventosProximos($filtros),
            'doacoes_recentes' => $this->getDoacoesRecentes($filtros),
        ];
    }

    /**
     * Pessoas por status
     */
    private function getPessoasPorStatus(array $filtros = []): array
    {
        $query = Pessoa::query();
        $this->aplicarFiltrosBasicos($query, $filtros);
        
        return $query->selectRaw('status_participacao, COUNT(*) as total')
            ->groupBy('status_participacao')
            ->pluck('total', 'status_participacao')
            ->toArray();
    }

    /**
     * Pessoas por cidade
     */
    private function getPessoasPorCidade(array $filtros = []): array
    {
        $query = Pessoa::query();
        $this->aplicarFiltrosBasicos($query, $filtros);
        
        return $query->selectRaw('cidade_pessoa, COUNT(*) as total')
            ->whereNotNull('cidade_pessoa')
            ->groupBy('cidade_pessoa')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->pluck('total', 'cidade_pessoa')
            ->toArray();
    }

    /**
     * Pessoas por faixa etária
     */
    private function getPessoasPorIdade(array $filtros = []): array
    {
        $query = Pessoa::query();
        $this->aplicarFiltrosBasicos($query, $filtros);
        
        return $query->selectRaw('
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 12 THEN "0-11 anos"
                WHEN TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 18 THEN "12-17 anos"
                WHEN TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 30 THEN "18-29 anos"
                WHEN TIMESTAMPDIFF(YEAR, data_nasc_pessoa, CURDATE()) < 50 THEN "30-49 anos"
                ELSE "50+ anos"
            END as faixa_etaria,
            COUNT(*) as total
        ')
        ->groupBy('faixa_etaria')
        ->pluck('total', 'faixa_etaria')
        ->toArray();
    }

    /**
     * Projetos por categoria
     */
    private function getProjetosPorCategoria(array $filtros = []): array
    {
        $query = Projeto::query();
        
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodo($query, $filtros['periodo'], 'created_at');
        }
        
        return $query->join('categorias', 'projetos.categoria_id', '=', 'categorias.id')
            ->selectRaw('categorias.nome_categoria, COUNT(*) as total')
            ->groupBy('categorias.id', 'categorias.nome_categoria')
            ->pluck('total', 'nome_categoria')
            ->toArray();
    }

    /**
     * Doações por mês
     */
    private function getDoacoesPorMes(array $filtros = []): array
    {
        $query = Doacao::query();
        
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodo($query, $filtros['periodo'], 'data_doacao');
        }
        
        return $query->selectRaw('MONTH(data_doacao) as mes, SUM(valor_doacao) as total')
            ->whereYear('data_doacao', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();
    }

    /**
     * Presenças por mês
     */
    private function getPresencasPorMes(array $filtros = []): array
    {
        $query = DB::table('presencas');
        
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodoTabela($query, $filtros['periodo'], 'data_presenca');
        }
        
        return $query->selectRaw('MONTH(data_presenca) as mes, COUNT(*) as total')
            ->whereYear('data_presenca', now()->year)
            ->where('status_presenca', 'Presente')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();
    }

    /**
     * Pessoas recentes
     */
    private function getPessoasRecentes(array $filtros = []): array
    {
        $query = Pessoa::query();
        $this->aplicarFiltrosBasicos($query, $filtros);
        
        return $query->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['nome_pessoa', 'email_pessoa', 'cidade_pessoa', 'created_at'])
            ->toArray();
    }

    /**
     * Projetos populares
     */
    private function getProjetosPopulares(array $filtros = []): array
    {
        $query = Projeto::query();
        
        if (isset($filtros['categoria_id'])) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }
        
        return $query->withCount('participacoes')
            ->orderBy('participacoes_count', 'desc')
            ->limit(5)
            ->get(['nome_projeto', 'vagas_preenchidas', 'vagas_disponiveis', 'participacoes_count'])
            ->toArray();
    }

    /**
     * Eventos próximos
     */
    private function getEventosProximos(array $filtros = []): array
    {
        $query = Evento::query();
        
        if (isset($filtros['projeto_id'])) {
            $query->where('projeto_id', $filtros['projeto_id']);
        }
        
        return $query->where('data_evento', '>=', now())
            ->orderBy('data_evento')
            ->limit(5)
            ->get(['nome_evento', 'data_evento', 'local_evento', 'status_evento'])
            ->toArray();
    }

    /**
     * Doações recentes
     */
    private function getDoacoesRecentes(array $filtros = []): array
    {
        $query = Doacao::query();
        
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodo($query, $filtros['periodo'], 'data_doacao');
        }
        
        return $query->with('doador')
            ->orderBy('data_doacao', 'desc')
            ->limit(5)
            ->get(['tipo_doacao', 'valor_doacao', 'data_doacao', 'doador_id'])
            ->toArray();
    }

    /**
     * Aplicar filtros básicos
     */
    private function aplicarFiltrosBasicos($query, array $filtros): void
    {
        if (isset($filtros['periodo'])) {
            $this->aplicarFiltroPeriodo($query, $filtros['periodo'], 'data_ingresso_projeto');
        }
        
        if (isset($filtros['categoria_id'])) {
            $query->whereHas('categorias', function ($q) use ($filtros) {
                $q->where('categoria_id', $filtros['categoria_id']);
            });
        }
        
        if (isset($filtros['projeto_id'])) {
            $query->whereHas('participacoes', function ($q) use ($filtros) {
                $q->where('projeto_id', $filtros['projeto_id']);
            });
        }
    }

    /**
     * Aplicar filtro de período
     */
    private function aplicarFiltroPeriodo($query, string $periodo, string $campo): void
    {
        switch ($periodo) {
            case 'hoje':
                $query->whereDate($campo, today());
                break;
            case 'semana':
                $query->whereBetween($campo, [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereMonth($campo, now()->month)->whereYear($campo, now()->year);
                break;
            case 'ano':
                $query->whereYear($campo, now()->year);
                break;
        }
    }

    /**
     * Aplicar filtro de período para tabelas
     */
    private function aplicarFiltroPeriodoTabela($query, string $periodo, string $campo): void
    {
        switch ($periodo) {
            case 'hoje':
                $query->whereDate($campo, today());
                break;
            case 'semana':
                $query->whereBetween($campo, [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereMonth($campo, now()->month)->whereYear($campo, now()->year);
                break;
            case 'ano':
                $query->whereYear($campo, now()->year);
                break;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Projeto;
use App\Models\Categoria;
use App\Models\Doacao;
use App\Models\Evento;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $projetos = Projeto::all();
        
        return view('relatorios.index', compact('categorias', 'projetos'));
    }

    public function gerar(Request $request)
    {
        $tipo = $request->input('tipo');
        $formato = $request->input('formato', 'pdf');
        $categoria_id = $request->input('categoria_id');
        $projeto_id = $request->input('projeto_id');
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        
        try {
            switch ($tipo) {
                case 'pessoas':
                    $dados = $this->gerarRelatorioPessoas($formato, $categoria_id, $projeto_id, $data_inicio, $data_fim);
                    break;
                    
                case 'projetos':
                    $dados = $this->gerarRelatorioProjetos($formato, $categoria_id, $data_inicio, $data_fim);
                    break;
                    
                case 'eventos':
                    $dados = $this->gerarRelatorioEventos($formato, $data_inicio, $data_fim);
                    break;
                    
                case 'doacoes':
                    $dados = $this->gerarRelatorioDoacoes($formato, $data_inicio, $data_fim);
                    break;
                    
                case 'completo':
                    $dados = $this->gerarRelatorioCompleto($formato, $data_inicio, $data_fim);
                    break;
                    
                default:
                    return back()->with('error', 'Tipo de relatório inválido.');
            }
            
            return $dados;
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar relatório: ' . $e->getMessage());
        }
    }
    
    private function gerarRelatorioPessoas($formato, $categoria_id, $projeto_id, $data_inicio, $data_fim)
    {
        $query = Pessoa::query();
        
        if ($categoria_id) {
            $query->whereHas('categorias', function($q) use ($categoria_id) {
                $q->where('categorias.id', $categoria_id);
            });
        }
        
        if ($projeto_id) {
            $query->whereHas('participacoes', function($q) use ($projeto_id) {
                $q->where('projeto_id', $projeto_id);
            });
        }
        
        if ($data_inicio) {
            $query->where('created_at', '>=', $data_inicio);
        }
        
        if ($data_fim) {
            $query->where('created_at', '<=', $data_fim);
        }
        
        $pessoas = $query->get();
        
        if ($formato === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('relatorios.pdf.pessoas', [
                'pessoas' => $pessoas,
                'total' => $pessoas->count()
            ]);
            
            return $pdf->download('relatorio_pessoas.pdf');
        }
        
        if ($formato === 'excel') {
            return Excel::download(new class($pessoas) implements \Maatwebsite\Excel\Concerns\FromCollection {
                protected $collection;
                
                public function __construct($collection) {
                    $this->collection = $collection;
                }
                
                public function collection() {
                    return $this->collection->map(function($pessoa) {
                        return [
                            'Nome' => $pessoa->nome_pessoa,
                            'CPF' => $pessoa->cpf_pessoa,
                            'Email' => $pessoa->email_pessoa,
                            'Telefone' => $pessoa->telefone_pessoa,
                            'Data Cadastro' => $pessoa->created_at->format('d/m/Y'),
                        ];
                    });
                }
            }, 'relatorio_pessoas.xlsx');
        }
        
        // CSV
        $filename = 'relatorio_pessoas.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $callback = function() use ($pessoas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nome', 'CPF', 'Email', 'Telefone', 'Data Cadastro']);
            
            foreach ($pessoas as $pessoa) {
                fputcsv($file, [
                    $pessoa->nome_pessoa,
                    $pessoa->cpf_pessoa,
                    $pessoa->email_pessoa,
                    $pessoa->telefone_pessoa,
                    $pessoa->created_at->format('d/m/Y')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function gerarRelatorioProjetos($formato, $categoria_id, $data_inicio, $data_fim)
    {
        $query = Projeto::with('categoria');
        
        if ($categoria_id) {
            $query->where('categoria_id', $categoria_id);
        }
        
        if ($data_inicio) {
            $query->where('data_inicio', '>=', $data_inicio);
        }
        
        if ($data_fim) {
            $query->where('data_fim', '<=', $data_fim);
        }
        
        $projetos = $query->get();
        
        return response()->json([
            'titulo' => 'Participantes por Projeto',
            'total' => $projetos->count(),
            'dados' => $projetos->map(function($projeto) {
                return [
                    'nome' => $projeto->nome_projeto,
                    'categoria' => $projeto->categoria->nome_categoria ?? '-',
                    'vagas_disponiveis' => $projeto->vagas_disponiveis,
                    'status' => $projeto->status_projeto,
                ];
            })
        ]);
    }
    
    private function gerarRelatorioEventos($formato, $data_inicio, $data_fim)
    {
        $query = Evento::query();
        
        if ($data_inicio) {
            $query->where('data_evento', '>=', $data_inicio);
        }
        
        if ($data_fim) {
            $query->where('data_evento', '<=', $data_fim);
        }
        
        $eventos = $query->get();
        
        return response()->json([
            'titulo' => 'Presença em Eventos',
            'total' => $eventos->count(),
            'dados' => $eventos->map(function($evento) {
                return [
                    'nome' => $evento->nome_evento,
                    'data' => $evento->data_evento ? $evento->data_evento->format('d/m/Y') : '-',
                    'local' => $evento->local_evento,
                    'status' => $evento->status_evento,
                ];
            })
        ]);
    }
    
    private function gerarRelatorioDoacoes($formato, $data_inicio, $data_fim)
    {
        $query = Doacao::query();
        
        if ($data_inicio) {
            $query->where('data_doacao', '>=', $data_inicio);
        }
        
        if ($data_fim) {
            $query->where('data_doacao', '<=', $data_fim);
        }
        
        $doacoes = $query->get();
        
        if ($formato === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('relatorios.pdf.doacoes', [
                'doacoes' => $doacoes,
                'total' => $doacoes->count(),
                'total_valor' => $doacoes->sum('valor_doacao')
            ]);
            
            return $pdf->download('relatorio_doacoes.pdf');
        }
        
        if ($formato === 'excel') {
            return Excel::download(new class($doacoes) implements \Maatwebsite\Excel\Concerns\FromCollection {
                protected $collection;
                
                public function __construct($collection) {
                    $this->collection = $collection;
                }
                
                public function collection() {
                    return $this->collection->map(function($doacao) {
                        return [
                            'Doador' => $doacao->nome_doador,
                            'Valor' => $doacao->valor_doacao,
                            'Tipo' => $doacao->tipo_doacao,
                            'Forma Pagamento' => $doacao->forma_pagamento ?? '-',
                            'Data' => $doacao->data_doacao ? $doacao->data_doacao->format('d/m/Y') : '-',
                            'Status' => $doacao->status_doacao,
                        ];
                    });
                }
            }, 'relatorio_doacoes.xlsx');
        }
        
        // CSV
        $filename = 'relatorio_doacoes.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $callback = function() use ($doacoes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Doador', 'Valor', 'Tipo', 'Forma Pagamento', 'Data', 'Status']);
            
            foreach ($doacoes as $doacao) {
                fputcsv($file, [
                    $doacao->nome_doador,
                    'R$ ' . number_format($doacao->valor_doacao, 2, ',', '.'),
                    $doacao->tipo_doacao,
                    $doacao->forma_pagamento ?? '-',
                    $doacao->data_doacao ? $doacao->data_doacao->format('d/m/Y') : '-',
                    $doacao->status_doacao,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function gerarRelatorioCompleto($formato, $data_inicio, $data_fim)
    {
        $pessoas_total = Pessoa::count();
        $projetos_total = Projeto::count();
        $eventos_total = Evento::count();
        $doacoes_total = Doacao::count();
        $valor_total = Doacao::sum('valor_doacao') ?? 0;
        
        // Calcular indicadores reais
        $pessoas_ativas = Pessoa::where('ativo', true)->count();
        $taxa_participacao = $pessoas_total > 0 ? ($pessoas_ativas / $pessoas_total) * 100 : 0;
        
        $eventos_mes = Evento::whereMonth('data_evento', now()->month)->count();
        $engajamento = $eventos_mes > 5 ? 'Excelente' : ($eventos_mes > 2 ? 'Bom' : 'Regular');
        
        $taxa_participacao_status = $taxa_participacao > 80 ? 'Alta' : ($taxa_participacao > 50 ? 'Média' : 'Baixa');
        
        $media_doacoes = $doacoes_total > 0 ? $valor_total / $doacoes_total : 0;
        $sustentabilidade = $media_doacoes > 500 ? 'Fortemente Sustentável' : ($media_doacoes > 200 ? 'Sustentável' : 'Instável');
        
        if ($formato === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('relatorios.pdf.completo', [
                'pessoas_total' => $pessoas_total,
                'projetos_total' => $projetos_total,
                'eventos_total' => $eventos_total,
                'doacoes_total' => $doacoes_total,
                'valor_total' => $valor_total,
                'periodo' => $data_inicio && $data_fim ? "De $data_inicio até $data_fim" : 'Todos os períodos',
                'taxa_participacao_status' => $taxa_participacao_status,
                'engajamento' => $engajamento,
                'sustentabilidade' => $sustentabilidade,
                'taxa_participacao_percent' => number_format($taxa_participacao, 1)
            ]);
            
            return $pdf->download('relatorio_completo.pdf');
        }
        
        if ($formato === 'excel') {
            $dados = [
                ['Relatório Completo'],
                ['Período', $data_inicio && $data_fim ? "De $data_inicio até $data_fim" : 'Todos os períodos'],
                ['Total de Pessoas', $pessoas_total],
                ['Total de Projetos', $projetos_total],
                ['Total de Eventos', $eventos_total],
                ['Total de Doações', $doacoes_total],
                ['Valor Total de Doações', 'R$ ' . number_format($valor_total, 2, ',', '.')]
            ];
            
            return Excel::download(new class($dados) implements \Maatwebsite\Excel\Concerns\FromArray {
                protected $data;
                
                public function __construct($data) {
                    $this->data = $data;
                }
                
                public function array(): array {
                    return $this->data;
                }
            }, 'relatorio_completo.xlsx');
        }
        
        // CSV
        $filename = 'relatorio_completo.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $callback = function() use ($pessoas_total, $projetos_total, $eventos_total, $doacoes_total, $valor_total) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Relatório Completo']);
            fputcsv($file, ['Total de Pessoas', $pessoas_total]);
            fputcsv($file, ['Total de Projetos', $projetos_total]);
            fputcsv($file, ['Total de Eventos', $eventos_total]);
            fputcsv($file, ['Total de Doações', $doacoes_total]);
            fputcsv($file, ['Valor Total de Doações', 'R$ ' . number_format($valor_total, 2, ',', '.')]);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function download(Request $request)
    {
        // Lógica para download
        return back()->with('success', 'Download iniciado!');
    }
}

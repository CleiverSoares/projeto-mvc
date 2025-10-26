<?php

namespace App\Http\Controllers;

use App\Services\PessoaService;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PessoaController extends Controller
{
    protected $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    /**
     * Listar pessoas
     */
    public function index(Request $request): View
    {
        $filtros = $request->only(['nome', 'cpf', 'cidade', 'bairro', 'status', 'categoria_id', 'projeto_id']);
        $pessoas = $this->pessoaService->listarPessoas($filtros);
        $categorias = Categoria::ativos()->ordenados()->get();
        
        return view('pessoas.index', compact('pessoas', 'categorias', 'filtros'));
    }

    /**
     * Exibir formulário de criação
     */
    public function create(): View
    {
        // Apenas admin ou gestor podem criar pessoas
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado. Apenas administradores e gestores podem criar pessoas.');
        }
        
        $categorias = Categoria::ativos()->ordenados()->get();
        return view('pessoas.create', compact('categorias'));
    }

    /**
     * Criar nova pessoa
     */
    public function store(Request $request): RedirectResponse
    {
        // Apenas admin ou gestor podem criar pessoas
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        $request->validate([
            'nome_pessoa' => 'required|string|max:250',
            'cpf_pessoa' => 'required|string|unique:pessoas,cpf_pessoa',
            'data_nasc_pessoa' => 'required|date',
            'telefone_pessoa' => 'required|string|max:20',
            'email_pessoa' => 'required|email|unique:pessoas,email_pessoa',
            'categorias' => 'array',
            'categorias.*' => 'exists:categorias,id',
            'responsavel.nome_responsavel' => 'required_if:idade,<,18',
            'responsavel.cpf_responsavel' => 'required_if:idade,<,18',
            'responsavel.telefone_responsavel' => 'required_if:idade,<,18',
        ]);

        try {
            $pessoa = $this->pessoaService->criarPessoa($request->all());
            
            return redirect()
                ->route('pessoas.show', $pessoa->id)
                ->with('success', 'Pessoa cadastrada com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar pessoa: ' . $e->getMessage());
        }
    }

    /**
     * Exibir pessoa específica
     */
    public function show(int $id): View
    {
        $pessoa = $this->pessoaService->buscarPessoa($id);
        
        if (!$pessoa) {
            abort(404, 'Pessoa não encontrada');
        }
        
        return view('pessoas.show', compact('pessoa'));
    }

    /**
     * Exibir formulário de edição
     */
    public function edit(int $id): View
    {
        // Apenas admin ou gestor podem editar pessoas
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado. Apenas administradores e gestores podem editar pessoas.');
        }
        
        $pessoa = $this->pessoaService->buscarPessoa($id);
        
        if (!$pessoa) {
            abort(404, 'Pessoa não encontrada');
        }
        
        $categorias = Categoria::ativos()->ordenados()->get();
        
        return view('pessoas.edit', compact('pessoa', 'categorias'));
    }

    /**
     * Atualizar pessoa
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Apenas admin ou gestor podem atualizar pessoas
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        $request->validate([
            'nome_pessoa' => 'required|string|max:250',
            'cpf_pessoa' => 'required|string|unique:pessoas,cpf_pessoa,' . $id,
            'data_nasc_pessoa' => 'required|date',
            'telefone_pessoa' => 'required|string|max:20',
            'email_pessoa' => 'required|email|unique:pessoas,email_pessoa,' . $id,
            'categorias' => 'array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        try {
            $resultado = $this->pessoaService->atualizarPessoa($id, $request->all());
            
            if ($resultado) {
                return redirect()
                    ->route('pessoas.show', $id)
                    ->with('success', 'Pessoa atualizada com sucesso!');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Pessoa não encontrada');
            }
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar pessoa: ' . $e->getMessage());
        }
    }

    /**
     * Deletar pessoa
     */
    public function destroy(int $id): RedirectResponse
    {
        // Apenas admin ou gestor podem excluir pessoas
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        try {
            $resultado = $this->pessoaService->deletarPessoa($id);
            
            if ($resultado) {
                return redirect()
                    ->route('pessoas.index')
                    ->with('success', 'Pessoa excluída com sucesso!');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Pessoa não encontrada');
            }
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir pessoa: ' . $e->getMessage());
        }
    }

    /**
     * API - Listar pessoas
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $filtros = $request->only(['nome', 'cpf', 'cidade', 'bairro', 'status', 'categoria_id', 'projeto_id']);
        $pessoas = $this->pessoaService->listarPessoas($filtros);
        
        return response()->json($pessoas);
    }

    /**
     * API - Buscar pessoa
     */
    public function apiShow(int $id): JsonResponse
    {
        $pessoa = $this->pessoaService->buscarPessoa($id);
        
        if (!$pessoa) {
            return response()->json(['error' => 'Pessoa não encontrada'], 404);
        }
        
        return response()->json($pessoa);
    }

    /**
     * API - Criar pessoa
     */
    public function apiStore(Request $request): JsonResponse
    {
        $request->validate([
            'nome_pessoa' => 'required|string|max:250',
            'cpf_pessoa' => 'required|string|unique:pessoas,cpf_pessoa',
            'data_nasc_pessoa' => 'required|date',
            'telefone_pessoa' => 'required|string|max:20',
            'email_pessoa' => 'required|email|unique:pessoas,email_pessoa',
        ]);

        try {
            $pessoa = $this->pessoaService->criarPessoa($request->all());
            
            return response()->json([
                'success' => true,
                'data' => $pessoa,
                'message' => 'Pessoa criada com sucesso'
            ], 201);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar pessoa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API - Atualizar pessoa
     */
    public function apiUpdate(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'nome_pessoa' => 'required|string|max:250',
            'cpf_pessoa' => 'required|string|unique:pessoas,cpf_pessoa,' . $id,
            'data_nasc_pessoa' => 'required|date',
            'telefone_pessoa' => 'required|string|max:20',
            'email_pessoa' => 'required|email|unique:pessoas,email_pessoa,' . $id,
        ]);

        try {
            $resultado = $this->pessoaService->atualizarPessoa($id, $request->all());
            
            if ($resultado) {
                $pessoa = $this->pessoaService->buscarPessoa($id);
                
                return response()->json([
                    'success' => true,
                    'data' => $pessoa,
                    'message' => 'Pessoa atualizada com sucesso'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pessoa não encontrada'
                ], 404);
            }
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar pessoa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API - Deletar pessoa
     */
    public function apiDestroy(int $id): JsonResponse
    {
        try {
            $resultado = $this->pessoaService->deletarPessoa($id);
            
            if ($resultado) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pessoa excluída com sucesso'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pessoa não encontrada'
                ], 404);
            }
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir pessoa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar CSV
     */
    public function exportarCsv(Request $request)
    {
        $filtros = $request->only(['nome', 'cpf', 'cidade', 'bairro', 'status', 'categoria_id', 'projeto_id']);
        $csv = $this->pessoaService->exportarCsv($filtros);
        
        $filename = 'pessoas_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Obter estatísticas
     */
    public function estatisticas(): JsonResponse
    {
        $estatisticas = $this->pessoaService->getEstatisticas();
        
        return response()->json($estatisticas);
    }
}

<?php

namespace App\Services;

use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PessoaService
{
    protected $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepository)
    {
        $this->pessoaRepository = $pessoaRepository;
    }

    /**
     * Listar pessoas com filtros
     */
    public function listarPessoas(array $filtros = []): LengthAwarePaginator
    {
        return $this->pessoaRepository->buscarComFiltros($filtros);
    }

    /**
     * Criar nova pessoa
     */
    public function criarPessoa(array $dados): Model
    {
        DB::beginTransaction();
        
        try {
            // Processar dados
            $dados = $this->processarDadosPessoa($dados);
            
            // Criar pessoa
            $pessoa = $this->pessoaRepository->create($dados);
            
            // Processar categorias se fornecidas
            if (isset($dados['categorias']) && is_array($dados['categorias'])) {
                $pessoa->categorias()->sync($dados['categorias']);
            }
            
            // Processar responsável se for menor de idade
            if ($pessoa->isMenorDeIdade() && isset($dados['responsavel'])) {
                $this->criarResponsavel($pessoa, $dados['responsavel']);
            }
            
            DB::commit();
            return $pessoa->load(['categorias', 'responsavel']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Atualizar pessoa
     */
    public function atualizarPessoa(int $id, array $dados): bool
    {
        DB::beginTransaction();
        
        try {
            $pessoa = $this->pessoaRepository->find($id);
            if (!$pessoa) {
                return false;
            }
            
            // Processar dados
            $dados = $this->processarDadosPessoa($dados);
            
            // Atualizar pessoa
            $resultado = $this->pessoaRepository->update($id, $dados);
            
            // Atualizar categorias
            if (isset($dados['categorias']) && is_array($dados['categorias'])) {
                $pessoa->categorias()->sync($dados['categorias']);
            }
            
            // Atualizar responsável
            if ($pessoa->isMenorDeIdade() && isset($dados['responsavel'])) {
                $this->atualizarResponsavel($pessoa, $dados['responsavel']);
            }
            
            DB::commit();
            return $resultado;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Deletar pessoa
     */
    public function deletarPessoa(int $id): bool
    {
        return $this->pessoaRepository->delete($id);
    }

    /**
     * Buscar pessoa por ID
     */
    public function buscarPessoa(int $id): ?Model
    {
        return $this->pessoaRepository->findWith($id, ['categorias', 'responsavel', 'participacoes.projeto']);
    }

    /**
     * Obter estatísticas
     */
    public function getEstatisticas(): array
    {
        return $this->pessoaRepository->getEstatisticas();
    }

    /**
     * Processar dados da pessoa
     */
    private function processarDadosPessoa(array $dados): array
    {
        // Limpar CPF
        if (isset($dados['cpf_pessoa'])) {
            $dados['cpf_pessoa'] = preg_replace('/[^0-9]/', '', $dados['cpf_pessoa']);
        }
        
        // Limpar telefone
        if (isset($dados['telefone_pessoa'])) {
            $dados['telefone_pessoa'] = preg_replace('/[^0-9]/', '', $dados['telefone_pessoa']);
        }
        
        // Processar arquivos
        if (isset($dados['foto_pessoa']) && $dados['foto_pessoa']->isValid()) {
            $dados['foto_pessoa'] = $this->salvarArquivo($dados['foto_pessoa'], 'fotos');
        }
        
        if (isset($dados['documento_cpf']) && $dados['documento_cpf']->isValid()) {
            $dados['documento_cpf'] = $this->salvarArquivo($dados['documento_cpf'], 'documentos');
        }
        
        return $dados;
    }

    /**
     * Criar responsável
     */
    private function criarResponsavel(Pessoa $pessoa, array $dadosResponsavel): void
    {
        $dadosResponsavel['pessoa_id'] = $pessoa->id;
        $pessoa->responsavel()->create($dadosResponsavel);
    }

    /**
     * Atualizar responsável
     */
    private function atualizarResponsavel(Pessoa $pessoa, array $dadosResponsavel): void
    {
        if ($pessoa->responsavel) {
            $pessoa->responsavel->update($dadosResponsavel);
        } else {
            $this->criarResponsavel($pessoa, $dadosResponsavel);
        }
    }

    /**
     * Salvar arquivo
     */
    private function salvarArquivo($arquivo, string $pasta): string
    {
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $caminho = $arquivo->storeAs($pasta, $nomeArquivo, 'public');
        return $caminho;
    }

    /**
     * Exportar dados para CSV
     */
    public function exportarCsv(array $filtros = []): string
    {
        $pessoas = $this->pessoaRepository->buscarComFiltros($filtros);
        
        $csv = "Nome,CPF,Email,Telefone,Cidade,Bairro,Status,Data Ingresso\n";
        
        foreach ($pessoas as $pessoa) {
            $csv .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s\n",
                $pessoa->nome_pessoa,
                $pessoa->cpf_pessoa,
                $pessoa->email_pessoa,
                $pessoa->telefone_pessoa,
                $pessoa->cidade_pessoa ?? '',
                $pessoa->bairro_pessoa ?? '',
                $pessoa->status_participacao,
                $pessoa->data_ingresso_projeto ?? ''
            );
        }
        
        return $csv;
    }
}

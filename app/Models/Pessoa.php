<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'uuid_pessoa',
        'nome_pessoa',
        'cpf_pessoa',
        'rg_pessoa',
        'data_nasc_pessoa',
        'sexo_pessoa',
        'estado_civil',
        'cor_raca',
        'nacionalidade',
        'naturalidade',
        'telefone_pessoa',
        'email_pessoa',
        'telefone_emergencia',
        'contato_emergencia_nome',
        'parentesco_emergencia',
        'cep_pessoa',
        'endereco_pessoa',
        'numero_endereco',
        'complemento_endereco',
        'bairro_pessoa',
        'cidade_pessoa',
        'estado_pessoa',
        'pais_pessoa',
        'renda_familiar',
        'profissao_pessoa',
        'escolaridade',
        'situacao_trabalho',
        'possui_deficiencia',
        'tipo_deficiencia',
        'medicamentos_uso',
        'alergias',
        'plano_saude',
        'tipo_sangue',
        'data_ingresso_projeto',
        'status_participacao',
        'observacoes_pessoa',
        'aceita_termos',
        'autoriza_imagem',
        'foto_pessoa',
        'documento_cpf',
        'documento_rg',
        'comprovante_residencia',
        'ativo',
        'ultimo_acesso'
    ];

    protected $casts = [
        'data_nasc_pessoa' => 'date',
        'data_ingresso_projeto' => 'date',
        'ultimo_acesso' => 'datetime',
        'renda_familiar' => 'decimal:2',
        'possui_deficiencia' => 'boolean',
        'plano_saude' => 'boolean',
        'aceita_termos' => 'boolean',
        'autoriza_imagem' => 'boolean',
        'ativo' => 'boolean',
    ];

    protected $appends = ['idade', 'nome_completo'];

    // Accessors
    public function getIdadeAttribute()
    {
        return Carbon::parse($this->data_nasc_pessoa)->age;
    }

    public function getNomeCompletoAttribute()
    {
        return $this->nome_pessoa;
    }

    public function getEnderecoCompletoAttribute()
    {
        $endereco = [];
        
        if ($this->endereco_pessoa) {
            $endereco[] = $this->endereco_pessoa;
        }
        
        if ($this->numero_endereco) {
            $endereco[] = $this->numero_endereco;
        }
        
        if ($this->complemento_endereco) {
            $endereco[] = $this->complemento_endereco;
        }
        
        if ($this->bairro_pessoa) {
            $endereco[] = $this->bairro_pessoa;
        }
        
        if ($this->cidade_pessoa) {
            $endereco[] = $this->cidade_pessoa;
        }
        
        if ($this->estado_pessoa) {
            $endereco[] = $this->estado_pessoa;
        }
        
        return implode(', ', $endereco);
    }

    // Relacionamentos
    public function responsavel(): HasOne
    {
        return $this->hasOne(Responsavel::class);
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_pessoa');
    }

    public function participacoes(): HasMany
    {
        return $this->hasMany(Participacao::class);
    }

    public function presencas(): HasMany
    {
        return $this->hasMany(Presenca::class);
    }

    public function doacoes(): HasMany
    {
        return $this->hasMany(Doacao::class, 'doador_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status_participacao', $status);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->whereHas('categorias', function ($q) use ($categoriaId) {
            $q->where('categoria_id', $categoriaId);
        });
    }

    public function scopePorIdade($query, $idadeMin, $idadeMax = null)
    {
        $dataMax = Carbon::now()->subYears($idadeMin);
        $query->where('data_nasc_pessoa', '<=', $dataMax);
        
        if ($idadeMax) {
            $dataMin = Carbon::now()->subYears($idadeMax + 1);
            $query->where('data_nasc_pessoa', '>', $dataMin);
        }
        
        return $query;
    }

    public function scopePorCidade($query, $cidade)
    {
        return $query->where('cidade_pessoa', 'like', "%{$cidade}%");
    }

    public function scopePorBairro($query, $bairro)
    {
        return $query->where('bairro_pessoa', 'like', "%{$bairro}%");
    }

    // Métodos auxiliares
    public function isMenorDeIdade()
    {
        return $this->idade < 18;
    }

    public function temResponsavel()
    {
        return $this->responsavel()->exists();
    }

    public function getPercentualPresenca($projetoId = null)
    {
        $query = $this->presencas();
        
        if ($projetoId) {
            $query->where('projeto_id', $projetoId);
        }
        
        $totalPresencas = $query->count();
        $presencasConfirmadas = $query->where('status_presenca', 'Presente')->count();
        
        return $totalPresencas > 0 ? ($presencasConfirmadas / $totalPresencas) * 100 : 0;
    }

    public function getProjetosAtivos()
    {
        return $this->participacoes()
            ->where('status_inscricao', 'Aprovado')
            ->where('ativo', true)
            ->with('projeto')
            ->get()
            ->pluck('projeto');
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pessoa) {
            if (empty($pessoa->uuid_pessoa)) {
                $pessoa->uuid_pessoa = \Str::uuid();
            }
        });
    }
}

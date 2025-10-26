<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projeto extends Model
{
    use HasFactory;

    protected $table = 'projetos';

    protected $fillable = [
        'categoria_id',
        'uuid_projeto',
        'nome_projeto',
        'descricao_projeto',
        'objetivos_projeto',
        'metodologia_projeto',
        'data_inicio',
        'data_fim',
        'vagas_disponiveis',
        'vagas_preenchidas',
        'idade_minima',
        'idade_maxima',
        'requisitos_projeto',
        'documentos_necessarios',
        'local_projeto',
        'endereco_projeto',
        'bairro_projeto',
        'cidade_projeto',
        'horario_inicio',
        'horario_fim',
        'dias_semana',
        'valor_mensalidade',
        'gratuito',
        'formas_pagamento',
        'status_projeto',
        'observacoes_projeto',
        'ativo'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'horario_inicio' => 'datetime:H:i',
        'horario_fim' => 'datetime:H:i',
        'dias_semana' => 'array',
        'valor_mensalidade' => 'decimal:2',
        'gratuito' => 'boolean',
        'vagas_disponiveis' => 'integer',
        'vagas_preenchidas' => 'integer',
        'idade_minima' => 'integer',
        'idade_maxima' => 'integer',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function participacoes(): HasMany
    {
        return $this->hasMany(Participacao::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

    public function presencas(): HasMany
    {
        return $this->hasMany(Presenca::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status_projeto', $status);
    }

    public function scopeComVagas($query)
    {
        return $query->whereRaw('vagas_preenchidas < vagas_disponiveis');
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    // Métodos auxiliares
    public function getVagasRestantesAttribute()
    {
        return max(0, $this->vagas_disponiveis - $this->vagas_preenchidas);
    }

    public function getPercentualOcupacaoAttribute()
    {
        return $this->vagas_disponiveis > 0 
            ? ($this->vagas_preenchidas / $this->vagas_disponiveis) * 100 
            : 0;
    }

    public function getParticipantesAtivosAttribute()
    {
        return $this->participacoes()
            ->where('status_inscricao', 'Aprovado')
            ->where('ativo', true)
            ->count();
    }

    public function temVagasDisponiveis()
    {
        return $this->vagas_restantes > 0;
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($projeto) {
            if (empty($projeto->uuid_projeto)) {
                $projeto->uuid_projeto = \Str::uuid();
            }
        });
    }
}

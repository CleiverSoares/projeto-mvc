<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participacao extends Model
{
    use HasFactory;

    protected $table = 'participacoes';

    protected $fillable = [
        'pessoa_id',
        'projeto_id',
        'uuid_participacao',
        'data_inscricao',
        'status_inscricao',
        'data_aprovacao',
        'data_inicio_participacao',
        'data_fim_participacao',
        'motivo_rejeicao',
        'motivo_cancelamento',
        'observacoes_participacao',
        'total_presencas',
        'total_faltas',
        'percentual_presenca',
        'pagamento_em_dia',
        'ultimo_pagamento',
        'valor_pago',
        'ativo'
    ];

    protected $casts = [
        'data_inscricao' => 'date',
        'data_aprovacao' => 'date',
        'data_inicio_participacao' => 'date',
        'data_fim_participacao' => 'date',
        'ultimo_pagamento' => 'date',
        'total_presencas' => 'integer',
        'total_faltas' => 'integer',
        'percentual_presenca' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'pagamento_em_dia' => 'boolean',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status_inscricao', $status);
    }

    public function scopeAprovados($query)
    {
        return $query->where('status_inscricao', 'Aprovado');
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($participacao) {
            if (empty($participacao->uuid_participacao)) {
                $participacao->uuid_participacao = \Str::uuid();
            }
        });
    }
}

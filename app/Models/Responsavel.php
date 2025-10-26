<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';

    protected $fillable = [
        'pessoa_id',
        'uuid_responsavel',
        'nome_responsavel',
        'cpf_responsavel',
        'rg_responsavel',
        'telefone_responsavel',
        'email_responsavel',
        'parentesco',
        'outro_parentesco',
        'profissao_responsavel',
        'renda_responsavel',
        'empresa_responsavel',
        'cep_responsavel',
        'endereco_responsavel',
        'numero_responsavel',
        'complemento_responsavel',
        'bairro_responsavel',
        'cidade_responsavel',
        'estado_responsavel',
        'observacoes_responsavel',
        'ativo'
    ];

    protected $casts = [
        'renda_responsavel' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($responsavel) {
            if (empty($responsavel->uuid_responsavel)) {
                $responsavel->uuid_responsavel = \Str::uuid();
            }
        });
    }
}

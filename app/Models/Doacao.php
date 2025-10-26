<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'doacoes';

    protected $fillable = [
        'doador_id',
        'uuid_doacao',
        'tipo_doacao',
        'valor_doacao',
        'descricao_doacao',
        'itens_doados',
        'data_doacao',
        'status_doacao',
        'data_confirmacao',
        'comprovante_doacao',
        'observacoes_doacao',
        'ativo'
    ];

    protected $casts = [
        'valor_doacao' => 'decimal:2',
        'data_doacao' => 'date',
        'data_confirmacao' => 'date',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function doador(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'doador_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status_doacao', $status);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_doacao', $tipo);
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($doacao) {
            if (empty($doacao->uuid_doacao)) {
                $doacao->uuid_doacao = \Str::uuid();
            }
        });
    }
}

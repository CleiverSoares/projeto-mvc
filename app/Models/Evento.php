<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'projeto_id',
        'uuid_evento',
        'nome_evento',
        'descricao_evento',
        'tipo_evento',
        'data_evento',
        'hora_inicio',
        'hora_fim',
        'local_evento',
        'endereco_evento',
        'bairro_evento',
        'cidade_evento',
        'estado_evento',
        'capacidade_evento',
        'vagas_disponiveis',
        'valor_ingresso',
        'gratuito',
        'organizador_evento',
        'responsavel_evento',
        'telefone_contato',
        'email_contato',
        'status_evento',
        'observacoes_evento',
        'ativo'
    ];

    protected $casts = [
        'data_evento' => 'datetime',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'valor_ingresso' => 'decimal:2',
        'gratuito' => 'boolean',
        'capacidade_evento' => 'integer',
        'vagas_disponiveis' => 'integer',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
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
        return $query->where('status_evento', $status);
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($evento) {
            if (empty($evento->uuid_evento)) {
                $evento->uuid_evento = \Str::uuid();
            }
        });
    }
}

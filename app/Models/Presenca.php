<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presenca extends Model
{
    use HasFactory;

    protected $table = 'presencas';

    protected $fillable = [
        'pessoa_id',
        'evento_id',
        'projeto_id',
        'uuid_presenca',
        'data_presenca',
        'hora_chegada',
        'hora_saida',
        'status_presenca',
        'observacoes_presenca',
        'justificativa_falta',
        'ativo'
    ];

    protected $casts = [
        'data_presenca' => 'date',
        'hora_chegada' => 'datetime:H:i',
        'hora_saida' => 'datetime:H:i',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
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
        return $query->where('status_presenca', $status);
    }

    // Boot method para gerar UUID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($presenca) {
            if (empty($presenca->uuid_presenca)) {
                $presenca->uuid_presenca = \Str::uuid();
            }
        });
    }
}

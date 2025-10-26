<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome_categoria',
        'descricao_categoria',
        'cor_categoria',
        'icone_categoria',
        'ativo',
        'ordem'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // Relacionamentos
    public function pessoas(): BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class, 'categoria_pessoa');
    }

    public function projetos(): HasMany
    {
        return $this->hasMany(Projeto::class);
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('nome_categoria');
    }

    // Métodos auxiliares
    public function getTotalPessoasAttribute()
    {
        return $this->pessoas()->count();
    }

    public function getTotalProjetosAttribute()
    {
        return $this->projetos()->count();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';

    protected $fillable = [
        'chave_configuracao',
        'valor_configuracao',
        'descricao_configuracao',
        'tipo_configuracao',
        'categoria_configuracao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria_configuracao', $categoria);
    }

    // Métodos auxiliares
    public static function getValor($chave, $default = null)
    {
        $config = static::where('chave_configuracao', $chave)
            ->where('ativo', true)
            ->first();
        
        if (!$config) {
            return $default;
        }
        
        // Converter valor baseado no tipo
        switch ($config->tipo_configuracao) {
            case 'booleano':
                return (bool) $config->valor_configuracao;
            case 'numero':
                return is_numeric($config->valor_configuracao) 
                    ? (float) $config->valor_configuracao 
                    : $default;
            case 'json':
                return json_decode($config->valor_configuracao, true) ?? $default;
            default:
                return $config->valor_configuracao;
        }
    }

    public static function setValor($chave, $valor, $tipo = 'texto', $categoria = 'geral', $descricao = null)
    {
        $config = static::where('chave_configuracao', $chave)->first();
        
        if (!$config) {
            $config = new static();
            $config->chave_configuracao = $chave;
        }
        
        $config->valor_configuracao = is_array($valor) ? json_encode($valor) : $valor;
        $config->tipo_configuracao = $tipo;
        $config->categoria_configuracao = $categoria;
        $config->descricao_configuracao = $descricao;
        $config->ativo = true;
        
        return $config->save();
    }
}

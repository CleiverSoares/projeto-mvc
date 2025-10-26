<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        return view('configuracoes.index');
    }

    public function update(Request $request)
    {
        // Lógica para atualizar configurações
        return back()->with('success', 'Configurações atualizadas!');
    }
}

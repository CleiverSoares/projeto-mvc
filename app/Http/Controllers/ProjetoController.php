<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('projetos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas admin ou gestor podem criar projetos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        return view('projetos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Apenas admin ou gestor podem criar projetos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        return back()->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projeto = Projeto::with(['categoria', 'participacoes'])->findOrFail($id);
        return view('projetos.show', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Apenas admin ou gestor podem editar projetos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        $projeto = Projeto::with('categoria')->findOrFail($id);
        return view('projetos.edit', compact('projeto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Apenas admin ou gestor podem atualizar projetos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Apenas admin ou gestor podem excluir projetos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        //
    }
}

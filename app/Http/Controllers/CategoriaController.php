<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categorias.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas admin ou gestor podem criar categorias
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Apenas admin ou gestor podem criar categorias
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Apenas admin ou gestor podem editar categorias
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Apenas admin ou gestor podem atualizar categorias
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
        // Apenas admin ou gestor podem excluir categorias
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }
}

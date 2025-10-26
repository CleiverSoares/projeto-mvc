<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use Illuminate\Http\Request;

class DoacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('doacoes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas admin ou gestor podem criar doações
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
        // Apenas admin ou gestor podem criar doações
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
        $doacao = Doacao::with('doador')->findOrFail($id);
        return view('doacoes.show', compact('doacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Apenas admin ou gestor podem editar doações
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Apenas admin ou gestor podem atualizar doações
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
        // Apenas admin ou gestor podem excluir doações
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }
}

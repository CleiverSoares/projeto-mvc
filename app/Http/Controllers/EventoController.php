<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('eventos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas admin ou gestor podem criar eventos
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
        // Apenas admin ou gestor podem criar eventos
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
        $evento = Evento::findOrFail($id);
        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Apenas admin ou gestor podem editar eventos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        
        $evento = Evento::findOrFail($id);
        return view('eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Apenas admin ou gestor podem atualizar eventos
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
        // Apenas admin ou gestor podem excluir eventos
        if (!in_array(auth()->user()->role ?? 'usuario', ['admin', 'gestor'])) {
            abort(403, 'Acesso negado.');
        }
        //
    }
}

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\UserController;

// Rotas de autenticação (públicas)
Auth::routes();

// Rotas protegidas
Route::middleware('auth')->group(function () {
    // Rotas principais
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API do Dashboard
    Route::get('/api/dashboard/dados', [DashboardController::class, 'dados'])->name('dashboard.dados');

    // Rotas de Pessoas
    Route::resource('pessoas', PessoaController::class);
    Route::get('/pessoas/exportar/csv', [PessoaController::class, 'exportarCsv'])->name('pessoas.exportar.csv');
    Route::get('/api/pessoas/estatisticas', [PessoaController::class, 'estatisticas'])->name('pessoas.estatisticas');
    
    // API de Pessoas
    Route::prefix('api')->group(function () {
        Route::get('/pessoas', [PessoaController::class, 'apiIndex'])->name('api.pessoas.index');
        Route::get('/pessoas/{id}', [PessoaController::class, 'apiShow'])->name('api.pessoas.show');
        Route::post('/pessoas', [PessoaController::class, 'apiStore'])->name('api.pessoas.store');
        Route::put('/pessoas/{id}', [PessoaController::class, 'apiUpdate'])->name('api.pessoas.update');
        Route::delete('/pessoas/{id}', [PessoaController::class, 'apiDestroy'])->name('api.pessoas.destroy');
    });
    
    // Rotas de Projetos
    Route::resource('projetos', ProjetoController::class);
    
    // Rotas de Categorias
    Route::resource('categorias', CategoriaController::class);
    
    // Rotas de Eventos
    Route::resource('eventos', EventoController::class);
    
    // Rotas de Doações
    Route::resource('doacoes', DoacaoController::class);
    
    // Rotas de Relatórios
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::post('/gerar', [RelatorioController::class, 'gerar'])->name('gerar');
        Route::get('/download', [RelatorioController::class, 'download'])->name('download');
    });
    
    // Rotas de Configurações
    Route::prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::get('/', [ConfiguracaoController::class, 'index'])->name('index');
        Route::post('/', [ConfiguracaoController::class, 'update'])->name('update');
    });
    
    // Rotas de Usuários
    Route::resource('users', UserController::class);
});

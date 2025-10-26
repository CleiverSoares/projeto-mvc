<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PessoaRepository;
use App\Services\PessoaService;
use App\Models\Pessoa;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(PessoaRepository::class, function ($app) {
            return new PessoaRepository($app->make(Pessoa::class));
        });

        // Services
        $this->app->bind(PessoaService::class, function ($app) {
            return new PessoaService($app->make(PessoaRepository::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

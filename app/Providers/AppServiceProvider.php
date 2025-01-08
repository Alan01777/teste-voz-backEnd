<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\ProdutosRepositoryInterface;
use App\Repositories\ProdutosRepository;
use App\Contracts\Repositories\CategoriasRepositoryInterface;
use App\Repositories\CategoriasRepository;
use App\Contracts\Services\ProdutosServiceInterface;
use App\Services\ProdutosService;
use App\Contracts\Services\CategoriasServiceInterface;
use App\Services\CategoriasService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProdutosRepositoryInterface::class,
            ProdutosRepository::class
        );

        $this->app->bind(
            CategoriasRepositoryInterface::class,
            CategoriasRepository::class
        );

        $this->app->bind(
            ProdutosServiceInterface::class,
            ProdutosService::class
        );

        $this->app->bind(
            CategoriasServiceInterface::class,
            CategoriasService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

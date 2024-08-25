<?php

namespace App\Providers;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Infrastructure\Persistence\VeiculoRepository;
use Illuminate\Support\ServiceProvider;

class VeiculoRepositoyProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            VeiculoRepositoryInterface::class,
            VeiculoRepository::class
        );
    }
}

<?php

namespace Tests\Unit\Providers;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Infrastructure\Persistence\VeiculoRepository;
use App\Providers\VeiculoRepositoyProvider;
use Illuminate\Foundation\Application;
use Tests\TestCase;

class VeiculoRepositoyProviderTest extends TestCase
{
    public function testserviceProviderRegistersTheCorrectImplementation()
    {
        $app = new Application();
        $provider = new VeiculoRepositoyProvider($app);

        $provider->register();

        $this->assertInstanceOf(
            VeiculoRepository::class,
            $app->make(VeiculoRepositoryInterface::class)
        );
    }
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosVendidosUseCase;
use App\Http\Controllers\BuscarTodosVeiculosVendidosController;
use Exception;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

final class BuscarTodosVeiculosVendidosControllerTest extends TestCase
{
    private $buscarTodosVeiculosVendidosUseCase;
    private $buscarTodosVeiculosVendidosController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->buscarTodosVeiculosVendidosUseCase = Mockery::mock(BuscarTodosVeiculosVendidosUseCase::class);
        $this->buscarTodosVeiculosVendidosController = new BuscarTodosVeiculosVendidosController(
            $this->buscarTodosVeiculosVendidosUseCase
        );
    }

    public function testAllSoldVehiclesCanBeFound(): void
    {
        $this->buscarTodosVeiculosVendidosUseCase->shouldReceive('executar')
            ->once()->andReturn($this->buscarTodosVeiculosVendidosUseCase)
            ->shouldReceive('toArray')->once()->andReturn([]);
        
        $response = $this->buscarTodosVeiculosVendidosController->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInternalServerErrorWhenExceptionIsThrown(): void
    {
        $this->buscarTodosVeiculosVendidosUseCase->shouldReceive('executar')->once()->andThrow(
            new Exception()
        );

        $response = $this->buscarTodosVeiculosVendidosController->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
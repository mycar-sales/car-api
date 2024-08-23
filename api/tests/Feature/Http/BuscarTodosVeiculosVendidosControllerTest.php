<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosVendidosUseCase;
use App\Http\Controllers\BuscarTodosVeiculosVendidosController;
use Exception;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

/**
 * Class BuscarTodosVeiculosVendidosControllerTest
 * @package Tests\Unit\Http\Controllers
 */
final class BuscarTodosVeiculosVendidosControllerTest extends TestCase
{
    /**
     * @var BuscarTodosVeiculosVendidosUseCase|BuscarTodosVeiculosVendidosUseCase&Mockery\MockInterface&Mockery\LegacyMockInterface|Mockery\MockInterface&Mockery\LegacyMockInterface
     */
    private BuscarTodosVeiculosVendidosUseCase $buscarTodosVeiculosVendidosUseCase;
    /**
     * @var BuscarTodosVeiculosVendidosController
     */
    private BuscarTodosVeiculosVendidosController $buscarTodosVeiculosVendidosController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->buscarTodosVeiculosVendidosUseCase = Mockery::mock(BuscarTodosVeiculosVendidosUseCase::class);
        $this->buscarTodosVeiculosVendidosController = new BuscarTodosVeiculosVendidosController(
            $this->buscarTodosVeiculosVendidosUseCase
        );
    }

    /**
     * @return void
     */
    public function testAllSoldVehiclesCanBeFound(): void
    {
        $this->buscarTodosVeiculosVendidosUseCase->shouldReceive('executar')
            ->once()->andReturn([]);

        $response = $this->buscarTodosVeiculosVendidosController->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testInternalServerErrorWhenExceptionIsThrown(): void
    {
        $this->buscarTodosVeiculosVendidosUseCase->shouldReceive('executar')->once()->andThrow(
            new Exception()
        );

        $response = $this->buscarTodosVeiculosVendidosController->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

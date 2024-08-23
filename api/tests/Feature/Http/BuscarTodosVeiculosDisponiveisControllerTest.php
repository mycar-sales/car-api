<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosDisponiveisUseCase;
use App\Http\Controllers\BuscarTodosVeiculosDisponiveisController;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

/**
 * Class BuscarTodosVeiculosDisponiveisControllerTest
 * @package Tests\Unit\Http\Controllers
 */
final class BuscarTodosVeiculosDisponiveisControllerTest extends TestCase
{
    /**
     * @var BuscarTodosVeiculosDisponiveisUseCase|BuscarTodosVeiculosDisponiveisUseCase&Mockery\MockInterface&Mockery\LegacyMockInterface|Mockery\MockInterface&Mockery\LegacyMockInterface
     */
    private $buscarTodosVeiculosDisponiveisUseCase;
    /**
     * @var BuscarTodosVeiculosDisponiveisController
     */
    private $buscarTodosVeiculosDisponiveisController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->buscarTodosVeiculosDisponiveisUseCase = Mockery::mock(BuscarTodosVeiculosDisponiveisUseCase::class);
        $this->buscarTodosVeiculosDisponiveisController = new BuscarTodosVeiculosDisponiveisController(
            $this->buscarTodosVeiculosDisponiveisUseCase
        );
    }

    /**
     * @return void
     */
    public function testAllAvailableVehiclesCanBeFound(): void
    {
        $this->buscarTodosVeiculosDisponiveisUseCase->shouldReceive('executar')
            ->once()->andReturn([]);

        $response = $this->buscarTodosVeiculosDisponiveisController->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testInternalServerErrorWhenExceptionIsThrown(): void
    {
        $this->buscarTodosVeiculosDisponiveisUseCase->shouldReceive('executar')
            ->once()->andThrow(new \Exception());

        $response = $this->buscarTodosVeiculosDisponiveisController->__invoke();

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

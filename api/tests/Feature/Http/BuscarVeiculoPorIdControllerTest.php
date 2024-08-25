<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\UseCases\BuscarVeiculoPorIdUseCase;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use App\Http\Controllers\BuscarVeiculoPorIdController;
use Exception;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

/**
 * Class BuscarVeiculoPorIdControllerTest
 * @package Tests\Feature\Http\Controllers
 */
final class BuscarVeiculoPorIdControllerTest extends TestCase
{
    /**
     * @var BuscarVeiculoPorIdUseCase|BuscarVeiculoPorIdUseCase&Mockery\MockInterface&Mockery\LegacyMockInterface|Mockery\MockInterface&Mockery\LegacyMockInterface
     */
    private $buscarVeiculoPorIdUseCase;
    /**
     * @var BuscarVeiculoPorIdController
     */
    private $buscarVeiculoPorIdController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->buscarVeiculoPorIdUseCase = Mockery::mock(BuscarVeiculoPorIdUseCase::class);
        $this->buscarVeiculoPorIdController = new BuscarVeiculoPorIdController($this->buscarVeiculoPorIdUseCase);
    }

    /**
     * @return void
     */
    public function testVehicleCanBeFoundById(): void
    {
        $this->buscarVeiculoPorIdUseCase->shouldReceive('executar')
            ->once()->andReturn(
                new Veiculo(
                    new VeiculoMarca('Ford'),
                    new VeiculoModelo('Fiesta'),
                    2021,
                    new VeiculoCor('Blue'),
                    new VeiculoPreco(9000.00),
                    'ABC-1234'
                )
            );

        $response = $this->buscarVeiculoPorIdController->__invoke(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testVehicleCannotBeFoundWithInvalidId(): void
    {
        $this->buscarVeiculoPorIdUseCase->shouldReceive('executar')->once()->andReturn(null);

        $response = $this->buscarVeiculoPorIdController->__invoke(0);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testInternalServerErrorWhenExceptionIsThrown(): void
    {
        $this->buscarVeiculoPorIdUseCase->shouldReceive('executar')
            ->once()->andThrow(new Exception());

        $response = $this->buscarVeiculoPorIdController->__invoke(0);

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

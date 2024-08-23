<?php
declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Core\Domain\UseCases\CadastrarVeiculoUseCase;
use App\Http\Controllers\CadastrarVeiculoController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;
use Mockery;

/**
 * Class CadastrarVeiculoControllerTest
 * @package Tests\Unit\Http\Controllers
 */
final class CadastrarVeiculoControllerTest extends TestCase
{
    /**
     * @var CadastrarVeiculoUseCase|CadastrarVeiculoUseCase&Mockery\MockInterface&Mockery\LegacyMockInterface|Mockery\MockInterface&Mockery\LegacyMockInterface
     */
    private CadastrarVeiculoUseCase $cadastrarVeiculoUseCase;
    /**
     * @var CadastrarVeiculoController
     */
    private CadastrarVeiculoController $cadastrarVeiculoController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cadastrarVeiculoUseCase = Mockery::mock(CadastrarVeiculoUseCase::class);
        $this->cadastrarVeiculoController = new CadastrarVeiculoController(
            $this->cadastrarVeiculoUseCase
        );
    }

    /**
     * @return void
     */
    public function testVehicleCanBeRegistered(): void
    {
        $data = [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        $this->cadastrarVeiculoUseCase->shouldReceive('execute')->once();

        $request = new Request($data);
        $response = $this->cadastrarVeiculoController->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testVehicleCannotBeRegisteredWithInvalidData(): void
    {
        $data = [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        $this->cadastrarVeiculoUseCase->shouldReceive('execute')->once()
            ->andThrow(new BadRequestHttpException());

        $request = new Request($data);
        $response = $this->cadastrarVeiculoController->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testInternalServerErrorWhenExceptionIsThrown(): void
    {
        $data = [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        $this->cadastrarVeiculoUseCase->shouldReceive('execute')->once()->andThrow(new \Exception());

        $request = new Request($data);
        $response = $this->cadastrarVeiculoController->__invoke($request);

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

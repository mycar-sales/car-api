<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Core\Domain\UseCases\UpdateVeiculoUseCase;
use App\Http\Controllers\UpdateVeiculoController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

final class UpdateVeiculoControllerTest extends TestCase
{
    private $updateVeiculoUseCase;
    private $updateVeiculoController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateVeiculoUseCase = Mockery::mock(UpdateVeiculoUseCase::class);
        $this->updateVeiculoController = new UpdateVeiculoController($this->updateVeiculoUseCase);
    }

    public function testVeiculoCanBeUpdated(): void
    {
        $this->updateVeiculoUseCase->shouldReceive('executar')->once();

        $request = new Request([
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ]);

        $response = $this->updateVeiculoController->__invoke(1, $request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Veículo atualizado com sucesso'], $response->getData(true));
    }

    public function testVeiculoUpdateFailsWhenNoMatchingId(): void
    {
        $this->updateVeiculoUseCase->shouldReceive('executar')->once()
            ->andThrow(new NotFoundHttpException('Not Found'));

        $request = new Request([
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ]);

        $response = $this->updateVeiculoController->__invoke(1, $request);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['message' => 'Not Found'], $response->getData(true));
    }

    public function testveiculoUpdateFailsWhenBadRequest(): void
    {
        $this->updateVeiculoUseCase->shouldReceive('executar')->once()->andThrow(
            new BadRequestHttpException('Bad Request')
        );

        $request = new Request([
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ]);

        $response = $this->updateVeiculoController->__invoke(1, $request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(['message' => 'Bad Request'], $response->getData(true));
    }

    public function testInternalServerErrorWhenExceptionIsThrow(): void
    {
        $this->updateVeiculoUseCase->shouldReceive('executar')->once()->andThrow(
            new Exception()
        );

        $request = new Request([
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ]);

        $response = $this->updateVeiculoController->__invoke(1, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
    }
}

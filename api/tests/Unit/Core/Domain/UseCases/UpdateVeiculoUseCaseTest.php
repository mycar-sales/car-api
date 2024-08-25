<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\UseCases\UpdateVeiculoUseCase;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Mockery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

final class UpdateVeiculoUseCaseTest extends TestCase
{
    private $veiculoRepository;
    private $updateVeiculoUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = Mockery::mock(VeiculoRepositoryInterface::class);
        $this->updateVeiculoUseCase = new UpdateVeiculoUseCase($this->veiculoRepository);
    }

    public function testVeiculoCanBeUpdated(): void
    {
        $veiculo = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00),
            'ABC-1234',
            true
        );
        $veiculo->setId(1);

        $this->veiculoRepository->shouldReceive('findById')->once()->andReturn($veiculo);
        $this->veiculoRepository->shouldReceive('update')->once()->andReturn(true);

        $data = [
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ];

        $this->updateVeiculoUseCase->executar($veiculo->getId(), $data);

        $this->assertEquals('Ford', $veiculo->getMarca()->getValue());
        $this->assertEquals('Fiesta', $veiculo->getModelo()->getValue());
        $this->assertEquals(2021, $veiculo->getAno());
        $this->assertEquals('Blue', $veiculo->getCor()->getValue());
        $this->assertEquals(9000.00, $veiculo->getPreco()->getValue());
        $this->assertEquals('XYZ-5678', $veiculo->getPlaca());
        $this->assertFalse($veiculo->isDisponivel());
    }

    public function testVeiculoUpdateFailsWhenNoMatchingId(): void
    {
        $this->veiculoRepository->shouldReceive('findById')->once()->andReturn(null);

        $this->expectException(NotFoundHttpException::class);

        $data = [
            'marca' => 'Ford',
            'modelo' => 'Fiesta',
            'ano' => 2021,
            'cor' => 'Blue',
            'preco' => 9000.00,
            'placa' => 'XYZ-5678',
            'disponivel' => false
        ];

        $this->updateVeiculoUseCase->executar(1, $data);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

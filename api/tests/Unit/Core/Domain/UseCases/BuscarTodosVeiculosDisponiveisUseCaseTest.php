<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\UseCases\BuscarTodosVeiculosDisponiveisUseCase;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Tests\TestCase;
use Mockery;

final class BuscarTodosVeiculosDisponiveisUseCaseTest extends TestCase
{
    private VeiculoRepositoryInterface $veiculoRepository;
    private BuscarTodosVeiculosDisponiveisUseCase $buscarTodosVeiculosDisponiveisUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = Mockery::mock(VeiculoRepositoryInterface::class);
        $this->buscarTodosVeiculosDisponiveisUseCase = new
        BuscarTodosVeiculosDisponiveisUseCase($this->veiculoRepository);
    }

    public function testAllAvailableVehiclesCanBeFound(): void
    {
        $veiculos = [
            new Veiculo(
                new VeiculoMarca('Toyota'),
                new VeiculoModelo('Corolla'),
                2022,
                new VeiculoCor('Red'),
                new VeiculoPreco(10000.00),
                'ABC-1234'
            ),
            new Veiculo(
                new VeiculoMarca('Ford'),
                new VeiculoModelo('Fiesta'),
                2021,
                new VeiculoCor('Blue'),
                new VeiculoPreco(9000.00),
                'ABC-1234'
            )
        ];

        $this->veiculoRepository->shouldReceive('findAllAvailable')->once()->andReturn($veiculos);

        $result = $this->buscarTodosVeiculosDisponiveisUseCase->executar()->toArray();

        $this->assertCount(2, $result);
        $this->assertIsArray($result[0]);
        $this->assertIsArray($result[1]);
    }

    public function testNoAvailableVehiclesCanBeFound(): void
    {
        $this->veiculoRepository->shouldReceive('findAllAvailable')->once()->andReturn([]);

        $result = $this->buscarTodosVeiculosDisponiveisUseCase->executar()->toArray();

        $this->assertCount(0, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
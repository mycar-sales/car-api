<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\UseCases\BuscarVeiculoPorIdUseCase;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Tests\TestCase;
use Mockery;

final class BuscarVeiculoPorIdUseCaseTest extends TestCase
{
    private VeiculoRepositoryInterface $veiculoRepository;
    private BuscarVeiculoPorIdUseCase $buscarVeiculoPorIdUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = Mockery::mock(VeiculoRepositoryInterface::class);
        $this->buscarVeiculoPorIdUseCase = new BuscarVeiculoPorIdUseCase($this->veiculoRepository);
    }

    public function testVehicleCanBeFoundById(): void
    {
        $veiculo = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00),
            'ABC-1234'
        );

        $this->veiculoRepository->shouldReceive('findById')->once()->andReturn($veiculo);

        $result = $this->buscarVeiculoPorIdUseCase->executar(1);

        $this->assertInstanceOf(Veiculo::class, $result);
    }

    public function testVehicleCannotBeFoundWithInvalidId(): void
    {
        $this->veiculoRepository->shouldReceive('findById')->once()->andReturn(null);

        $result = $this->buscarVeiculoPorIdUseCase->executar(0);

        $this->assertNull($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\UseCases\BuscarTodosVeiculosVendidosUseCase;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Tests\TestCase;
use Mockery;

final class BuscarTodosVeiculosVendidosUseCaseTest extends TestCase
{
    private $veiculoRepository;
    private $buscarTodosVeiculosVendidosUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = Mockery::mock(VeiculoRepositoryInterface::class);
        $this->buscarTodosVeiculosVendidosUseCase = new BuscarTodosVeiculosVendidosUseCase($this->veiculoRepository);
    }

    public function testAllSoldVehiclesCanBeFound(): void
    {
        $veiculos = [
            new Veiculo(
                new VeiculoMarca('Toyota'),
                new VeiculoModelo('Corolla'),
                2022,
                new VeiculoCor('Red'),
                new VeiculoPreco(10000.00)
            ),
            new Veiculo(
                new VeiculoMarca('Ford'),
                new VeiculoModelo('Fiesta'),
                2021,
                new VeiculoCor('Blue'),
                new VeiculoPreco(9000.00)
            )
        ];

        $this->veiculoRepository->shouldReceive('findAllSold')->once()->andReturn($veiculos);

        $result = $this->buscarTodosVeiculosVendidosUseCase->executar();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Veiculo::class, $result[0]);
        $this->assertInstanceOf(Veiculo::class, $result[1]);
    }

    public function testNoSoldVehiclesCanBeFound(): void
    {
        $this->veiculoRepository->shouldReceive('findAllSold')->once()->andReturn([]);

        $result = $this->buscarTodosVeiculosVendidosUseCase->executar();

        $this->assertCount(0, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

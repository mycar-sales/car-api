<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Persistence;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use App\Infrastructure\Persistence\VeiculoRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class VeiculoRepositoryTest extends TestCase
{
    protected VeiculoRepository $veiculoRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = new VeiculoRepository();
    }

    public function testSave(): void
    {
        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('insert')
            ->once()
            ->andReturnTrue();

        $veiculo = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $this->veiculoRepository->save($veiculo);

        $this->assertTrue(true);
    }

    public function testFindById(): void
    {
        $veiculoData = (object) [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('id', 1)
            ->andReturnSelf()
            ->shouldReceive('first')
            ->once()
            ->andReturn($veiculoData);

        $veiculo = $this->veiculoRepository->findById(1);

        $this->assertInstanceOf(Veiculo::class, $veiculo);
        $this->assertEquals('Toyota', $veiculo->getMarca()->getValue());
        $this->assertEquals('Corolla', $veiculo->getModelo()->getValue());
        $this->assertEquals(2022, $veiculo->getAno());
        $this->assertEquals('Red', $veiculo->getCor()->getValue());
        $this->assertEquals('10000', $veiculo->getPreco()->getValue());
    }

    public function testFindByIdNotFound(): void
    {
        $veiculoData = (object) [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('id', 1)
            ->andReturnSelf()
            ->shouldReceive('first')
            ->once()
            ->andReturn([]);

        $veiculo = $this->veiculoRepository->findById(1);
        $this->assertEquals(null, $veiculo);

    }

    public function testVehicleCanBeSaved(): void
    {
        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('insert')
            ->once()
            ->andReturnTrue();

        $veiculo = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $this->veiculoRepository->save($veiculo);

        $this->assertTrue(true);
    }

    public function testVehicleCanBeFoundById(): void
    {
        $veiculoData = (object) [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('id', 1)
            ->andReturnSelf()
            ->shouldReceive('first')
            ->once()
            ->andReturn($veiculoData);

        $veiculo = $this->veiculoRepository->findById(1);

        $this->assertInstanceOf(Veiculo::class, $veiculo);
        $this->assertEquals('Toyota', $veiculo->getMarca()->getValue());
        $this->assertEquals('Corolla', $veiculo->getModelo()->getValue());
        $this->assertEquals(2022, $veiculo->getAno());
        $this->assertEquals('Red', $veiculo->getCor()->getValue());
        $this->assertEquals('10000', $veiculo->getPreco()->getValue());
    }

    public function testAllAvailableVehiclesCanBeFound(): void
    {
        $veiculosData = [
            (object) [
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'ano' => 2022,
                'cor' => 'Red',
                'preco' => 10000.00
            ],
            (object) [
                'marca' => 'Ford',
                'modelo' => 'Fiesta',
                'ano' => 2021,
                'cor' => 'Blue',
                'preco' => 9000.00
            ]
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('disponivel', true)
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($veiculosData);

        $veiculos = $this->veiculoRepository->findAllAvailable();

        $this->assertCount(2, $veiculos);
        $this->assertInstanceOf(Veiculo::class, $veiculos[0]);
        $this->assertInstanceOf(Veiculo::class, $veiculos[1]);
    }

    public function testAllSoldVehiclesCanBeFound(): void
    {
        $veiculosData = [
            (object) [
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'ano' => 2022,
                'cor' => 'Red',
                'preco' => 10000.00
            ],
            (object) [
                'marca' => 'Ford',
                'modelo' => 'Fiesta',
                'ano' => 2021,
                'cor' => 'Blue',
                'preco' => 9000.00
            ]
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->with('disponivel', false)
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($veiculosData);

        $veiculos = $this->veiculoRepository->findAllSold();

        $this->assertCount(2, $veiculos);
        $this->assertInstanceOf(Veiculo::class, $veiculos[0]);
        $this->assertInstanceOf(Veiculo::class, $veiculos[1]);
    }
}

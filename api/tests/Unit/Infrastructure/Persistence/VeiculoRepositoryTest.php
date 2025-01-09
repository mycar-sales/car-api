<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Persistence;

use App\Core\Domain\Veiculos\Entities\Veiculo;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoMarca;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoModelo;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoCor;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoPreco;
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
            new VeiculoPreco(10000.00),
            'ABC-1234'
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
            'preco' => 10000.00,
            'placa' => 'ABC-1234',
            'disponivel' => true,
            'id' => 1
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
        $this->assertEquals(1, $veiculo->getId());
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
            new VeiculoPreco(10000.00),
            'ABC-1234'
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
            'preco' => 10000.00,
            'placa' => 'ABC-1234',
            'disponivel' => true,
            'id' => 1
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
        $this->assertEquals(1, $veiculo->getId());
    }

    public function testAllAvailableVehiclesCanBeFound(): void
    {
        $veiculosData = [
            (object) [
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'ano' => 2022,
                'cor' => 'Red',
                'preco' => 10000.00,
                'placa' => 'ABC-1234',
                'disponivel' => true,
                'id' => 3
            ],
            (object) [
                'marca' => 'Ford',
                'modelo' => 'Fiesta',
                'ano' => 2021,
                'cor' => 'Blue',
                'preco' => 9000.00,
                'placa' => 'DEF-5678',
                'disponivel' => false,
                'id' => 4
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
            ->shouldReceive('orderBy')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn(array_filter($veiculosData, fn($veiculo) => $veiculo->disponivel));

        $veiculos = $this->veiculoRepository->findAllAvailable();

        $this->assertCount(1, $veiculos);
        $this->assertEquals(3, $veiculos[0]->getId());
        $this->assertInstanceOf(Veiculo::class, $veiculos[0]);
        $this->assertArrayNotHasKey(1, $veiculos);
    }

    public function testAllSoldVehiclesCanBeFound(): void
    {
        $veiculosData = [
            (object) [
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'ano' => 2022,
                'cor' => 'Red',
                'preco' => 10000.00,
                'placa' => 'ABC-1234',
                'disponivel' => true,
                'id' => 4

            ],
            (object) [
                'marca' => 'Ford',
                'modelo' => 'Fiesta',
                'ano' => 2021,
                'cor' => 'Blue',
                'preco' => 9000.00,
                'placa' => 'DEF-5678',
                'disponivel' => false,
                'id' => 4
            ]
        ];

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->once()
            ->andReturnSelf()
            ->with('disponivel', false)
            ->shouldReceive('orderBy')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('toArray')
            ->once()
            ->andReturn(array_filter($veiculosData, fn($veiculo) => !$veiculo->disponivel));

        $veiculos = $this->veiculoRepository->findAllSold();

        $this->assertCount(1, $veiculos);
        $this->assertArrayNotHasKey(0, $veiculos);
        $this->assertInstanceOf(Veiculo::class, $veiculos[1]);
        $this->assertEquals(4, $veiculos[1]->getId());
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

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf();

        DB::shouldReceive('where')
            ->once()
            ->with('id', $veiculo->getId())
            ->andReturnSelf();

        DB::shouldReceive('update')
            ->once()
            ->andReturn(1);

        $this->veiculoRepository->update($veiculo);
    }

    public function testVeiculoUpdateFailsWhenNoMatchingId(): void
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

        DB::shouldReceive('table')
            ->once()
            ->with('veiculos')
            ->andReturnSelf();

        DB::shouldReceive('where')
            ->once()
            ->with('id', $veiculo->getId())
            ->andReturnSelf();

        DB::shouldReceive('update')
            ->once()
            ->andReturn(0);

        $this->veiculoRepository->update($veiculo);
    }
}

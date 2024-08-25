<?php

use PHPUnit\Framework\TestCase;
use App\Core\Domain\UseCases\BaseUseCase;
use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoPreco;

class BaseUseCaseTest extends TestCase
{
    public function testBaseUseCaseCanConvertVeiculosToArray()
    {
        $veiculo1 = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00),
            'ABC-1234',
            true
        );

        $veiculo2 = new Veiculo(
            new VeiculoMarca('Ford'),
            new VeiculoModelo('Fiesta'),
            2021,
            new VeiculoCor('Blue'),
            new VeiculoPreco(9000.00),
            'XYZ-5678',
            false
        );

        $baseUseCase = new class([$veiculo1, $veiculo2]) extends BaseUseCase {
            public function __construct(array $veiculos)
            {
                $this->veiculos = $veiculos;
            }
        };

        $expected = [
            [
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'ano' => 2022,
                'cor' => 'Red',
                'preco' => 10000.00,
                'disponivel' => true,
                'placa' => 'ABC-1234'
            ],
            [
                'marca' => 'Ford',
                'modelo' => 'Fiesta',
                'ano' => 2021,
                'cor' => 'Blue',
                'preco' => 9000.00,
                'disponivel' => false,
                'placa' => 'XYZ-5678'
            ]
        ];

        $this->assertEquals($expected, $baseUseCase->toArray());
    }

    public function testBaseUseCaseReturnsEmptyArrayWhenNoVeiculos()
    {
        $baseUseCase = new class([]) extends BaseUseCase {
            public function __construct(array $veiculos)
            {
                $this->veiculos = $veiculos;
            }
        };

        $this->assertEquals([], $baseUseCase->toArray());
    }
}
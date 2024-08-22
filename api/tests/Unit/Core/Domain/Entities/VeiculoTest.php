<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Entities;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use PHPUnit\Framework\TestCase;

final class VeiculoTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $this->assertInstanceOf(Veiculo::class, $vehicle);
        $this->assertEquals('Toyota', $vehicle->getMarca()->getValue());
        $this->assertEquals('Corolla', $vehicle->getModelo()->getValue());
        $this->assertEquals(2022, $vehicle->getAno());
        $this->assertEquals('Red', $vehicle->getCor()->getValue());
        $this->assertEquals('10000', $vehicle->getPreco()->getValue());
    }

    public function testMarcaCanBeSetAndRetrieved(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $vehicle->setMarca(new VeiculoMarca('Ford'));
        $this->assertEquals('Ford', $vehicle->getMarca()->getValue());
    }

    public function testModeloCanBeSetAndRetrieved(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $vehicle->setModelo(new VeiculoModelo('Camry'));
        $this->assertEquals('Camry', $vehicle->getModelo()->getValue());
    }

    public function testAnoCanBeSetAndRetrieved(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $vehicle->setAno(2023);
        $this->assertEquals(2023, $vehicle->getAno());
    }

    public function testCorCanBeSetAndRetrieved(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(10000.00)
        );

        $vehicle->setCor(new VeiculoCor('Blue'));
        $this->assertEquals('Blue', $vehicle->getCor()->getValue());
    }

    public function testPrecoCanBeSetAndRetrieved(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Toyota'),
            new VeiculoModelo('Corolla'),
            2022,
            new VeiculoCor('Red'),
            new VeiculoPreco(20000.00)
        );

        $vehicle->setPreco(new VeiculoPreco(25000.00));
        $this->assertEquals('25000', $vehicle->getPreco()->getValue());
    }

    public function testCanBeCreatedWithDifferentValues(): void
    {
        $vehicle = new Veiculo(
            new VeiculoMarca('Honda'),
            new VeiculoModelo('Civic'),
            2019,
            new VeiculoCor('Black'),
            new VeiculoPreco(15000.00)
        );

        $this->assertEquals('Honda', $vehicle->getMarca()->getValue());
        $this->assertEquals('Civic', $vehicle->getModelo()->getValue());
        $this->assertEquals(2019, $vehicle->getAno());
        $this->assertEquals('Black', $vehicle->getCor()->getValue());
        $this->assertEquals('15000', $vehicle->getPreco()->getValue());
    }
}

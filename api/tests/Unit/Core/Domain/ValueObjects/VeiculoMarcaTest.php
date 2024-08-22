<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\ValueObjects;

use App\Core\Domain\ValueObjects\VeiculoMarca;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class VeiculoMarcaTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VeiculoMarca::class,
            new VeiculoMarca('Toyota')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VeiculoMarca('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Toyota',
            (new VeiculoMarca('Toyota'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Toyota',
            (new VeiculoMarca('Ford'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePreco = new VeiculoMarca('Toyota');
        $this->assertEquals('Toyota', $vehiclePreco->__toString());
    }
}

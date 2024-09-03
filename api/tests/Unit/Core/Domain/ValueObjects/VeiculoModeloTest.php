<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use InvalidArgumentException;

final class VeiculoModeloTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VeiculoModelo::class,
            new VeiculoModelo('Corolla')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VeiculoModelo('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Corolla',
            (new VeiculoModelo('Corolla'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Corolla',
            (new VeiculoModelo('Camry'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePreco = new VeiculoModelo(   'Corolla');
        $this->assertEquals('Corolla', $vehiclePreco->__toString());
    }
}

<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use InvalidArgumentException;

 class VeiculoPrecoTest extends TestCase
{
    public function testCanBeCreatedFromValidFloat(): void
    {
        $this->assertInstanceOf(
            VeiculoPreco::class,
            new VeiculoPreco(10000.00)
        );
    }

    public function testCannotBeCreatedFromZeroOrNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VeiculoPreco(0);
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            '10000',
            (new VeiculoPreco(10000.00))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            '10000',
            (new VeiculoPreco(20000.00))->getValue()
        );
    }
     public function testToString(): void
     {
         $vehiclePreco = new VeiculoPreco(10000.00);
         $this->assertEquals('10000', $vehiclePreco->__toString());
     }
}

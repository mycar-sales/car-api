<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VeiculoCor;

final class VeiculoCorTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VeiculoCor::class,
            new VeiculoCor('Red')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VeiculoCor('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Red',
            (new VeiculoCor('Red'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Red',
            (new VeiculoCor('Blue'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePreco = new VeiculoCor('Red');
        $this->assertEquals('Red', $vehiclePreco->__toString());
    }
}

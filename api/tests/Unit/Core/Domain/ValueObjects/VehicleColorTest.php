<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VehicleColor;

final class VehicleColorTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VehicleColor::class,
            new VehicleColor('Red')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VehicleColor('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Red',
            (new VehicleColor('Red'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Red',
            (new VehicleColor('Blue'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePrice = new VehicleColor('Red');
        $this->assertEquals('Red', $vehiclePrice->__toString());
    }
}

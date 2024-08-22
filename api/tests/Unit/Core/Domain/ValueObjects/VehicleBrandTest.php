<?php
declare(strict_types=1);

use App\Core\Domain\ValueObjects\VehicleBrand;
use PHPUnit\Framework\TestCase;

final class VehicleBrandTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VehicleBrand::class,
            new VehicleBrand('Toyota')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VehicleBrand('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Toyota',
            (new VehicleBrand('Toyota'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Toyota',
            (new VehicleBrand('Ford'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePrice = new VehicleBrand('Toyota');
        $this->assertEquals('Toyota', $vehiclePrice->__toString());
    }
}

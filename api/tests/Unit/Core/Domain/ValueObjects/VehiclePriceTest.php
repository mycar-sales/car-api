<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VehiclePrice;

 class VehiclePriceTest extends TestCase
{
    public function testCanBeCreatedFromValidFloat(): void
    {
        $this->assertInstanceOf(
            VehiclePrice::class,
            new VehiclePrice(10000.00)
        );
    }

    public function testCannotBeCreatedFromZeroOrNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VehiclePrice(0);
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            '10000',
            (new VehiclePrice(10000.00))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            '10000',
            (new VehiclePrice(20000.00))->getValue()
        );
    }
     public function testToString(): void
     {
         $vehiclePrice = new VehiclePrice(10000.00);
         $this->assertEquals('10000', $vehiclePrice->__toString());
     }
}

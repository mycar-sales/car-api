<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\Domain\ValueObjects\VehicleModel;

final class VehicleModelTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            VehicleModel::class,
            new VehicleModel('Corolla')
        );
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new VehicleModel('');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Corolla',
            (new VehicleModel('Corolla'))->getValue()
        );
    }

    public function testCannotBeUsedAsString(): void
    {
        $this->assertNotEquals(
            'Corolla',
            (new VehicleModel('Camry'))->getValue()
        );
    }

    public function testToString(): void
    {
        $vehiclePrice = new VehicleModel(   'Corolla');
        $this->assertEquals('Corolla', $vehiclePrice->__toString());
    }
}

<?php
declare(strict_types=1);

use App\Core\Domain\Entities\Vehicle;
use App\Core\Domain\ValueObjects\VehicleBrand;
use App\Core\Domain\ValueObjects\VehicleColor;
use App\Core\Domain\ValueObjects\VehiclePrice;
use App\Core\Domain\ValueObjects\VehicleModel;
use PHPUnit\Framework\TestCase;

final class VehicleTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(10000.00)
        );

        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals('Toyota', $vehicle->getBrand()->getValue());
        $this->assertEquals('Corolla', $vehicle->getModel()->getValue());
        $this->assertEquals(2022, $vehicle->getYear());
        $this->assertEquals('Red', $vehicle->getColor()->getValue());
        $this->assertEquals('10000', $vehicle->getPrice()->getValue());
    }

    public function testBrandCanBeSetAndRetrieved(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(10000.00)
        );

        $vehicle->setBrand(new VehicleBrand('Ford'));
        $this->assertEquals('Ford', $vehicle->getBrand()->getValue());
    }

    public function testModelCanBeSetAndRetrieved(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(10000.00)
        );

        $vehicle->setModel(new VehicleModel('Camry'));
        $this->assertEquals('Camry', $vehicle->getModel()->getValue());
    }

    public function testYearCanBeSetAndRetrieved(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(10000.00)
        );

        $vehicle->setYear(2023);
        $this->assertEquals(2023, $vehicle->getYear());
    }

    public function testColorCanBeSetAndRetrieved(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(10000.00)
        );

        $vehicle->setColor(new VehicleColor('Blue'));
        $this->assertEquals('Blue', $vehicle->getColor()->getValue());
    }

    public function testPriceCanBeSetAndRetrieved(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Toyota'),
            new VehicleModel('Corolla'),
            2022,
            new VehicleColor('Red'),
            new VehiclePrice(20000.00)
        );

        $vehicle->setPrice(new VehiclePrice(25000.00));
        $this->assertEquals('25000', $vehicle->getPrice()->getValue());
    }

    public function testCanBeCreatedWithDifferentValues(): void
    {
        $vehicle = new Vehicle(
            new VehicleBrand('Honda'),
            new VehicleModel('Civic'),
            2019,
            new VehicleColor('Black'),
            new VehiclePrice(15000.00)
        );

        $this->assertEquals('Honda', $vehicle->getBrand()->getValue());
        $this->assertEquals('Civic', $vehicle->getModel()->getValue());
        $this->assertEquals(2019, $vehicle->getYear());
        $this->assertEquals('Black', $vehicle->getColor()->getValue());
        $this->assertEquals('15000', $vehicle->getPrice()->getValue());
    }
}

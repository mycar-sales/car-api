<?php
declare(strict_types=1);

namespace App\Core\Domain\Entities;

use App\Core\Domain\ValueObjects\VehicleBrand;
use App\Core\Domain\ValueObjects\VehicleModel;
use App\Core\Domain\ValueObjects\VehicleColor;
use App\Core\Domain\ValueObjects\VehiclePrice;

/**
 * Class Vehicle
 * @package App\Core\Domain\Entities
 */
class Vehicle
{
    /**
     * @var VehicleBrand
     */
    private VehicleBrand $brand;
    /**
     * @var VehicleModel
     */
    private VehicleModel $model;
    /**
     * @var int
     */
    private int $year;
    /**
     * @var VehicleColor
     */
    private VehicleColor $color;
    /**
     * @var VehiclePrice
     */
    private VehiclePrice $price;

    /**
     * @param VehicleBrand $brand
     * @param VehicleModel $model
     * @param int $year
     * @param VehicleColor $color
     * @param VehiclePrice $price
     */
    public function __construct(
        VehicleBrand $brand,
        VehicleModel $model,
        int          $year,
        VehicleColor $color,
        VehiclePrice $price
    )
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->color = $color;
        $this->price = $price;
    }

    /**
     * @return VehicleBrand
     */
    public function getBrand(): VehicleBrand
    {
        return $this->brand;
    }

    /**
     * @return VehicleModel
     */
    public function getModel(): VehicleModel
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return VehicleColor
     */
    public function getColor(): VehicleColor
    {
        return $this->color;
    }

    /**
     * @return VehiclePrice
     */
    public function getPrice(): VehiclePrice
    {
        return $this->price;
    }

    /**
     * @param VehicleBrand $brand
     */
    public function setBrand(VehicleBrand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @param VehicleModel $model
     */
    public function setModel(VehicleModel $model): void
    {
        $this->model = $model;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @param VehicleColor $color
     */
    public function setColor(VehicleColor $color): void
    {
        $this->color = $color;
    }

    /**
     * @param VehiclePrice $price
     */
    public function setPrice(VehiclePrice $price): void
    {
        $this->price = $price;
    }
}

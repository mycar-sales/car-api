<?php
declare(strict_types=1);

namespace App\Core\Domain\ValueObjects;

use InvalidArgumentException;

class VehiclePrice
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Vehicle price must be greater than zero");
        }

        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}


<?php
declare(strict_types=1);

namespace App\Core\Domain\ValueObjects;

use App\Core\Domain\Entities\BaseEntity;
use InvalidArgumentException;

class VeiculoCor extends BaseEntity
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Veiculo cor cannot be empty");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}


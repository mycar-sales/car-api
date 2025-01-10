<?php

declare(strict_types=1);

namespace App\Core\Domain\Veiculos\Entities;

use ReflectionClass;
use ReflectionException;

//NOSONAR
abstract class BaseEntity
{
    /**
     * Convert the object properties to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isPublic() || !property_exists($this, $property->getName())) {
                continue;
            }
            
            $value = $property->getValue($this); //NOSONAR

            if (is_object($value)) {
                $array[$property->getName()] = method_exists($value, '__toString') ? (string)$value : null;
                continue;
            }

            $array[$property->getName()] = $value;
        }

        return $array;
    }
}

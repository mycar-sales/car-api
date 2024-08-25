<?php
declare(strict_types=1);

namespace App\Core\Domain\Entities;

use ReflectionClass;
use ReflectionException;

abstract class BaseEntity
{
    /**
     * Convert the object properties to an associative array.
     *
     * @return array
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        $array = [];
        $reflection = new ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);

            if (is_object($value)) {
                $array[$property->getName()] = (string)$value;
                continue;
            }

            $array[$property->getName()] = $value;

        }

        return $array;
    }
}

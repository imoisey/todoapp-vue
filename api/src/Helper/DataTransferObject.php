<?php

declare(strict_types=1);

namespace App\Helper;

use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    public function toArray(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $reflectionProperty) {
            if ($reflectionProperty->isStatic()) {
                continue;
            }

            /** @var string */
            $data[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
        }

        return $data;
    }
}

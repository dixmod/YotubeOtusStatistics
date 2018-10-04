<?php

namespace Dixmod\Services\Serialize;

trait PropertyIterator
{
    public function jsonSerialize(array $excepts): array
    {
        $skipProperty = function (\ReflectionProperty $property) use ($excepts) {
            return array_filter($excepts, function ($value) use ($property) {
                return $value === $property->getName();
            });
        };

        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();

        $arrayOfProperties = [];
        foreach ($properties as $property) {
            if ($skipProperty($property)) {
                continue;
            }
            $property->setAccessible(true);
            $arrayOfProperties[$property->getName()] = $property->getValue($this);
        }

        return $arrayOfProperties;
    }
}
<?php

namespace Objement\DialFireApi\Parameters;

use ReflectionClass;
use ReflectionProperty;

abstract class ParameterBase
{
    public function getAsArray() {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

        $parametersArray = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $parametersArray[$property->getName()] = $property->getValue($this);
        }

        return $parametersArray;
    }
}
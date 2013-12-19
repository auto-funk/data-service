<?php

namespace DataService\DataGenerator;

use DataService\Model\Model;
use DataService\Model\Property;
use Faker\Generator;

class FakerDataGenerator implements DataGeneratorInterface
{
    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * {@inheritDoc}
     */
    public function generateCollection(Model $model)
    {
        $properties = $model->getProperties();
        $arrayData = array();
        for ($i = 0 ; $i < count($properties) ; $i ++) {
            $valueProperty = $this->generateData($properties[$i], $arrayData);

            $arrayData[$properties[$i]->getName()] = $valueProperty;
        }

        return $arrayData;
    }

    private function generateData(Property $property, array $arrayData)
    {
        if ($property->getType() === 'string' && is_null($property->getPattern()) && is_null($property->getFormat())) {
            return $this->generateSimpleDataString($property->getName());
        }
        if ($property->getType() === 'number' && is_null($property->getPattern()) && is_null($property->getFormat())) {
            return $this->faker->randomNumber($nbDigits = NULL);
        }
        if ($property->getType() === 'email' && is_null($property->getPattern()) && is_null($property->getFormat())) {
            return $this->faker->email;
        }
        if (!is_null($property->getPattern()) && is_null($property->getFormat())) {
            return $this->generateSimpleDataWithPattern($property, $arrayData);
        }
        if (is_null($property->getPattern()) && !is_null($property->getFormat())) {
            return $this->generateSimpleDataWithFormat($property, $arrayData);
        }
    }

    private function generateSimpleDataString($name)
    {
        try {
            return $this->faker->{$name};
        } catch (\InvalidArgumentException $e) {
            return $this->faker->sentence($nbWords = 4);
        }
    }

    private function generateSimpleDataWithPattern(Property $property, array $arrayData)
    {
        $pattern = $property->getPattern();
        $patternExplodeBegin = explode('{', $pattern);
        $finalValue = $patternExplodeBegin[0];
        foreach ($patternExplodeBegin as $value) {
            $patternExplodeEnd = explode('}', $value);
            $finalValue .= $this->verifyPatternVariable($patternExplodeEnd[0], $arrayData).$patternExplodeEnd[1];
        }

        return $finalValue;
    }

    private function verifyPatternVariable($variable, array $arrayData)
    {
        if (array_key_exists($variable, $arrayData)) {
            return strtolower($arrayData[$variable]);
        }
    }

    private function generateSimpleDataWithFormat(Property $property)
    {
        return "Not Yet Implemented";
    }
}

<?php

namespace DataService\DataGenerator;

use DataService\Model\Model;
use DataService\Model\Property;

class FakerDataGenerator implements DataGeneratorInterface
{
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker->var;
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
        if ($property->getName() === 'email' || $property->getType() === 'email') {
            $splitEmailPattern = explode("@", $property->getPattern());
            $splitPrefixEmailPattern = explode(".", $splitEmailPattern[0]);
            $prefixMail = '';
            if (count($splitPrefixEmailPattern) < 2) {
                $prefixMail = $this->verifyPatternVariable($splitPrefixEmailPattern[0], $arrayData);
            } else {
                $finalMail = (count($splitPrefixEmailPattern) > 2 ? 'error' : null);
                if ($finalMail === 'error') {
                    return 'error';
                }
                $count = 0;
                foreach ($splitPrefixEmailPattern as $value) {
                    $prefixMail .= ($count === 1) ? '.' : '';
                    $prefixMail .= $this->verifyPatternVariable($value, $arrayData);
                    $count ++;
                }
            }

            return $prefixMail.'@'.$splitEmailPattern[1];
        }

        return $this->faker->email;
    }

    private function verifyPatternVariable($variable, array $arrayData)
    {
        if (substr($variable, 0, 1) != '{' || substr($variable, -1) != '}') {
            return 'error';
        }
        $variable = substr($variable, 1, -1);
        if (array_key_exists($variable, $arrayData)) {
            return strtolower($arrayData[$variable]);
        }
    }

    private function generateSimpleDataWithFormat(Property $property)
    {
        return "Not Yet Implemented";
    }
}

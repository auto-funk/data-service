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
            return $this->generateSimpleDataWithFormat($property);
        }

        return $this->faker->sentence($nbWords = 4);
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
        if ('birthDate' === $property->getName() || 'birthdate' === $property->getName()) {
            return $this->generateBirthDate($property->getFormat());
        }

        return $this->faker->sentence($nbWords = 4);
    }

    private function generateBirthDate($format)
    {
        date_default_timezone_set('UTC');
        $day = $this->faker->dayOfMonth;
        $month = $this->faker->month;
        $year = $this->faker->year;
        $finalValue = '';
        if (strpos($format, '-')) {
            $separator = '-';
            $date = mb_split('-', $format);
        }
        if (strpos($format, '/')) {
            $separator = '/';
            $date = mb_split('/', $format);
        }
        if (strpos($format, ':')) {
            $separator = ':';
            $date = mb_split(':', $format);
        }
        if (0 === stripos($date[0], 'y')) {
            $finalValue .= $year;
        }
        if (0 === stripos($date[0], 'm')) {
            $finalValue .= $month;
        }
        if (0 === stripos($date[0], 'd')) {
            $finalValue .= $day;
        }
        $finalValue .= $separator;
        if (0 === stripos($date[1], 'y')) {
            $finalValue .= $year;
        }
        if (0 === stripos($date[1], 'm')) {
            $finalValue .= $month;
        }
        if (0 === stripos($date[1], 'd')) {
            $finalValue .= $day;
        }
        $finalValue .= $separator;
        if (0 === stripos($date[2], 'y')) {
            $finalValue .= $year;
        }
        if (0 === stripos($date[2], 'm')) {
            $finalValue .= $month;
        }
        if (0 === stripos($date[2], 'd')) {
            $finalValue .= $day;
        }

        return $finalValue;

    }
}

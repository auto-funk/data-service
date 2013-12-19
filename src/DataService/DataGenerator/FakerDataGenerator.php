<?php

namespace DataService\DataGenerator;

use DataService\Model\Model;

class FakerDataGenerator implements DataGeneratorInterface
{
    private $faker;

    public function __construct($faker)
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
            $valueProperty = $this->generateData($properties[$i]->getName(), $properties[$i]->getType(),
                                                 $properties[$i]->getPattern(), $properties[$i]->getFormat(), $arrayData);
            $arrayData[$properties[$i]->getName()] = $valueProperty;
        }

        return $arrayData;
    }

    private function generateData($name, $type, $pattern, $format, array $arrayData)
    {
        if ($type === 'string' && is_null($pattern) && is_null($format)) {
            return $this->generateSimpleDataString($name);
        }
        if ($type === 'number' && is_null($pattern) && is_null($format)) {
            return $this->faker->randomNumber($nbDigits = NULL);
        }
        if ($type === 'email' && is_null($pattern) && is_null($format)) {
            return $this->faker->safeEmail;
        }
        if (!is_null($pattern) && is_null($format)) {
            return $this->generateSimpleDataWithPattern($name, $type, $pattern, $arrayData);
        }
        if (is_null($pattern) && !is_null($format)) {
            return $this->generateSimpleDataWithFormat($name, $type, $format);
        }

    }

    private function generateSimpleDataString($name)
    {
        switch ($name) {
            case 'name':
                return $this->faker->name;
            case 'firstName':
                return $this->faker->firstName;
            case 'lastName':
                return $this->faker->lastName;
            case 'email':
                return $this->faker->safeEmail;
            case 'address':
                return $this->faker->address;
            case 'city':
                return $this->faker->city;
            case 'streetAddress':
                return $this->faker->streetAddress;
            case 'postcode':
                return $this->faker->postcode;
            case 'country':
                return $this->faker->country;
            case 'phoneNumber':
                return $this->faker->phoneNumber;
            default:
                return $this->faker->sentence($nbWords = 4);
        }
    }

    private function generateSimpleDataWithPattern($name, $type, $pattern, array $arrayData)
    {
        if ($name === 'email' || $type === 'email') {
            $splitEmailPattern = explode("@", $pattern);
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

        return $this->faker->safeEmail;
    }

    private function generateSimpleDataWithFormat($name, $type, $format)
    {
        return "Not Yet Implemented";
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
}

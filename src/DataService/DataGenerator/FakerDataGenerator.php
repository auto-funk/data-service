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
        $propertiesValue = array();
        $arrayData = array();
        for ($i = 0 ; $i < count($properties) ; $i ++) {
            $propertiesValue[$i] = $properties[$i]->getArrayAttributes();
            $valueProperty = $this->generateData($propertiesValue[$i]['name'], $propertiesValue[$i]['type'],
                                                 $propertiesValue[$i]['pattern'], $propertiesValue[$i]['format']);
            $arrayData[$propertiesValue[$i]['name']] = $valueProperty;
        }

        return $arrayData;
    }

    private function generateData($name, $type, $pattern, $format)
    {
        if ($type === 'string' && is_null($pattern) && is_null($format)) {
            return $this->generateSimpleDataString($name);
        }
        if ($type === 'number' && is_null($pattern) && is_null($format)) {
            return $this->faker->randomNumber($nbDigits = NULL);
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

}

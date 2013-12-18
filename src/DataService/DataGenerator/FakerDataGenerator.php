<?php

namespace DataService\DataGenerator;

use DataService\Model\Model;

class FakerDataGenerator implements DataGeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function generateCollection(Model $model, $app)
    {
        $properties = $model->getProperties();
        $propertiesValue = array();
        $arrayData = array();
        for ($i = 0 ; $i < count($properties) ; $i ++) {
            $propertiesValue[$i] = $properties[$i]->getArrayAttributes();
            $valueProperty = $this->generateData($app, $propertiesValue[$i]['name'], $propertiesValue[$i]['type'],
                                                 $propertiesValue[$i]['pattern'], $propertiesValue[$i]['format']);
            $arrayData[$propertiesValue[$i]['name']] = $valueProperty;
        }

        return $arrayData;
    }

    private function generateData($app, $name, $type, $pattern, $format)
    {
        if ($type === 'string' && is_null($pattern) && is_null($format)) {
            return $this->generateSimpleDataString($app, $name);
        }
        if ($type === 'number' && is_null($pattern) && is_null($format)) {
            return $app['faker']->randomNumber($nbDigits = NULL);
        }

    }

    private function generateSimpleDataString($app, $name)
    {
        switch ($name) {
            case 'name':
                return $app['faker']->name;
            case 'firstName':
                return $app['faker']->firstName;
            case 'lastName':
                return $app['faker']->lastName;
            case 'email':
                return $app['faker']->safeEmail;
            case 'address':
                return $app['faker']->address;
            case 'city':
                return $app['faker']->city;
            case 'streetAddress':
                return $app['faker']->streetAddress;
            case 'postcode':
                return $app['faker']->postcode;
            case 'country':
                return $app['faker']->country;
            case 'phoneNumber':
                return $app['faker']->phoneNumber;
            default:
                return $app['faker']->sentence($nbWords = 4);
        }
    }

}

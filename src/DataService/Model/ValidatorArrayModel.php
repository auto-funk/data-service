<?php

namespace DataService\Model;

use DataService\Model\Model;
use DataService\Model\Property;

class ValidatorArrayModel {

    private $arrayJSON;

    private $propertiesFromJSON;

    private $metadataFromJSON;

    private $filtersFromJSON;


    private $model;

    private $properties;

    private $name;

    private $description;

    private $filters;


    public function __construct(array $arrayJSON) {
        $this->arrayJSON = $arrayJSON;
        if (!isset($this->arrayJSON['model'])) {
            $this->arrayJSON = array();
        }
        if ($this->arrayJSON != array()) {
            $this->createPropertiesFromJSON();
            $this->createMetadataFromJSON();
            $this->createFiltersFromJSON();
            $this->model = new Model($this->name, $this->description, $this->properties, $this->filters);
        }
    }

    /**
     * Properties part.
     */

    private function createPropertiesFromJSON() {
        if (isset($this->arrayJSON['model']['properties'])) {
            $this->propertiesFromJSON = $this->arrayJSON['model']['properties'];
            $this->verifyPropertiesFromJSON();
        }
    }

    private function verifyPropertiesFromJSON() {
        $this->properties = array();
        if (!is_array($this->propertiesFromJSON)) {
            $this->propertiesFromJSON = null;
        }
        if ($this->propertiesFromJSON != null) {
            $this->createProperties();
        }
    }

    private function createProperties() {
        foreach ($this->propertiesFromJSON as $key => $value) {
            $property = $this->createProperty($key, $value);
            $this->addProperty($property);
        }
    }

    private function createProperty($name, $array) {
        if (!is_array($array)) {
            return null;
        }
        foreach ($array as $key => $value) {
            $type = $this->recoverTypeProperty($key, $value);
            $description = $this->recoverDescriptionProperty($key, $value);
            $pattern = $this->recoverPatternProperty($key, $value);
            $format = $this->recoverFormatProperty($key, $value);
        }
        $property = new Property($name, $type, $description, $pattern, $format);
        return $property;
    }

    private function addProperty($property) {
        /** Est ce qu'on permet a l'user de creer un model meme si une propriété est fausse, et du coup enlevé */
        if ($property === null) {
            return;
        }
        array_push($this->properties, $property);
    }

    private function recoverTypeProperty($key, $value) {
        if (strcmp($key, 'type') === 0) {
            return $value;
        }
    }

    private function recoverDescriptionProperty($key, $value) {
        if (strcmp($key, 'description') === 0) {
            return $value;
        }
    }

    private function recoverPatternProperty($key, $value) {
        if (strcmp($key, 'pattern') === 0) {
            return $value;
        }
    }

    private function recoverFormatProperty($key, $value) {
        if (strcmp($key, 'format') === 0) {
            return $value;
        }
    }


    /**
     * Metadata part.
     */

    private function createMetadataFromJSON() {
        if (isset($this->arrayJSON['model']['metadata'])) {
            $this->metadataFromJSON = $this->arrayJSON['model']['metadata'];
            $this->verifyMetadataFromJSON();
        }
    }

    private function verifyMetadataFromJSON() {
        if (!is_array($this->metadataFromJSON)) {
            $this->metadataFromJSON = null;
        }
        if ($this->metadataFromJSON != null) {
            $this->createMetadata();
        }
    }

    private function createMetadata() {
        foreach ($this->metadataFromJSON as $key => $value) {
            $this->createNameDescription($key, $value);
        }
    }

    private function createNameDescription($key, $value) {
        if (strcmp($key, 'name') === 0) {
            $this->verifyName($value);
        }
        if (strcmp($key, 'description') === 0) {
            $this->verifyDescription($value);
        }
    }

    private function verifyName($name) {
        foreach ($name as $key => $value) {
            $this->addName($key, $value);
        }
    }

    private function addName($key, $value) {
        if ($key != 'value') {
            return;
        }
        $this->name = $value;
    }

    private function verifyDescription($description) {
        foreach ($description as $key => $value) {
            $this->addDescription($key, $value);
        }
    }

    private function addDescription($key, $value) {
        if ($key != 'value') {
            return;
        }
        $this->description = $value;
    }


    /**
     * Filters part.
     */

    private function createFiltersFromJSON() {
        $this->filters = array();
        if (isset($this->arrayJSON['model']['filters'])) {
            $this->filtersFromJSON = $this->arrayJSON['model']['filters'];
            $this->verifyFiltersFromJSON();
        }
    }

    private function verifyFiltersFromJSON() {
        if (!is_array($this->filtersFromJSON)) {
            $this->filtersFromJSON = null;
        }
        $this->filters = array();
        if ($this->filtersFromJSON != null) {
            $this->createFilters();
        }
    }

    private function createFilters() {
        foreach ($this->filtersFromJSON as $key => $value) {
            $this->filters[$key] = $value;
        }
    }

    public function getArrayJSON() {
        return $this->arrayJSON;
    }

    public function getModel() {
        return $this->model;
    }

}
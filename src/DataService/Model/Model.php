<?php

namespace DataService\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Model
{
	private $name;

	private $description;

	private $properties;

	private $filters;

	public function __construct($name, $description = null, array $properties = array(), array $filters = array())
	{
		$this->name 	   = $name;
		$this->description = $description;
		$this->properties  = $properties;
		$this->filters 	   = $filters;
	}

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('name', new Assert\Type(array(
            'type'  =>  'string'
        )));
        $metadata->addPropertyConstraint('name', new Assert\Regex(array(
            'pattern'   => '/^[a-zA-Z0-9]*$/',
            'message'   => 'This value should not contain a blank space.'
        )));

        $metadata->addPropertyConstraint('description', new Assert\Type(array(
            'type'  =>  'string'
        )));

        $metadata->addPropertyConstraint('properties', new Assert\NotBlank());
        $metadata->addPropertyConstraint('properties', new Assert\Type(array(
            'type'  =>  'array'
        )));

        $metadata->addPropertyConstraint('filters', new Assert\Type(array(
            'type'  =>  'array'
        )));
    }

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getFilters()
	{
		return $this->filters;
	}

	public function getProperties()
	{
		return $this->properties;
	}

	public function getProperty($key, $default = null)
	{
		return isset($this->properties[$key]) ? $this->properties[$key] : $default;
	}
}
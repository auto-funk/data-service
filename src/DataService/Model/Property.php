<?php

namespace DataService\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Property
{
	private $name;

	private $type;

	private $description;

	private $pattern;

	private $format;

	public function __construct($name, $type, $description = null, $pattern = null, $format = null)
	{
		$this->name 		= $name;
		$this->type 		= $type;
		$this->description 	= $description;
		$this->pattern 		= $pattern;
		$this->format 		= $format;
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

        $metadata->addPropertyConstraint('type', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type', new Assert\Type(array(
            'type'  =>  'string'
        )));
        $metadata->addPropertyConstraint('type', new Assert\Regex(array(
            'pattern'   => '/^[a-zA-Z0-9]*$/',
            'message'   => 'This value should not contain a blank space.'
        )));

        $metadata->addPropertyConstraint('description', new Assert\Type(array(
            'type'  =>  'string'
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

	public function getType()
	{
		return $this->type;
	}

	public function getFormat()
	{
		return $this->format;
	}

	public function getPattern()
	{
		return $this->pattern;
	}
}

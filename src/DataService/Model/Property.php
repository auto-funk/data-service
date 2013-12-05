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

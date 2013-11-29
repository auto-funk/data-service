<?php

//namespace DataService\Model;

class Property
{
	private $name;

	private $description;

	private $type;

	private $format;

	private $pattern;

	public function __construct($name, $description, $type, $format=null, $pattern=null)
	{
		$this->name = $name;
		$this->description = $description;
		$this->type = $type;
		$this->format = $format;
		$this->pattern = $pattern;
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
<?php

namespace DataService\Model;

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
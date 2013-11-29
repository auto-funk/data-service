<?php

//namespace DataService\Model;

class Model
{
	private $name;

	private $description;

	private $filter;

	private $properties=array();

	public function __construct($name, $description, $filter, $properties)
	{
		$this->name = $name;
		$this->description = $description;
		$this->filter = $filter;
		$this->properties = $properties;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getFilter()
	{
		return $this->filter;
	}

	public function getProperties()
	{
		return $this->properties;
	}

}
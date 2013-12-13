<?php

namespace DataService\Model;

class Model
{
    private $metadata;

	private $properties;

	private $filters;

    public function __construct(array $metadata = array(), array $properties = array(), array $filters = array())
    {
        $this->metadata    = $metadata;
        $this->properties  = $properties;
        $this->filters 	   = $filters;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata) {
        $this->metadata = $metadata;
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

    public function addProperty($property) {
        array_push($this->properties, $property);
    }

    public function removeProperty($key) {
        if ($property = $this->getProperty($key) != null) {
            unset($property);
        }
    }
}
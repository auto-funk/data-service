<?php

namespace DataService\Model;

class Model
{
    private $metadata;

    private $properties;

    private $filters;

    public function __construct(Metadata $metadata, array $properties = array(), array $filters = array())
    {
        $this->metadata    = $metadata;
        $this->properties  = $properties;
        $this->filters 	   = $filters;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getName()
    {
        return $this->metadata->getName();
    }

    public function getDescription()
    {
        return $this->metadata->getDescription();
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

    public function isEqualTo($name)
    {
        return $this->getName() === $name;
    }
}

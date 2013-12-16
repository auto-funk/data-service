<?php

namespace DataService\Model;

class Metadata
{
    private $name;

    private $description;

    public function __construct($name, $description = null)
    {
        $this->name        = $name;
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }
}

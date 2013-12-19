<?php

namespace DataService\DataGenerator;

class Faker
{
    public $var;

    public function __construct($faker)
    {
        $this->var = $faker;
    }
}

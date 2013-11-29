<?php

//namespace DataService\Model;
require 'modelInterface.php';
require 'modelClass.php';
require 'propertyClass.php';

class InMemoryModelRepository implements ModelInterface
{
    private $model;

    public function __construct()
    {
        $this->model[] = new Model('Toto', 'test de la description toto', "filter to",
                                    new Property('name1', 'description name1', 'string', 'pattern1')
        );
        $this->model[] = new Model('Titi', 'test de la description titi', "filter ti",
                                    new Property('name2', 'description name2', 'string', 'pattern2')
        );
    }

    public function find(Model $model)
    {
        for($i=0;$i<count($this->model);$i++)
        {
            if($this->model[$i] == $model)
            {
                return $this->model[$i];
            }
        }
        return null;
    }

    public function findBy(Property $property)
    {
        for($i=0;$i<count($this->model);$i++)
        {
            for ($j=0; $j<$this->model ; $j++)
            {
                if(($this->model[$i])->getProperty($j) == $property)
                {
                    return ($this->model[$i])->getProperty($j);
                }
            }
        }
        return null;
    }

    public function findAll()
    {
        return $this->model;
    }

    public function add(Model $model)
    {
        $this->model[] = $model;
    }

    public function remove(Model $model)
    {
        for($i=0;$i<count($this->model);$i++)
        {
            if($this->model[$i] == $model)
            {
                unset($this->model[$i]);
                $this->model = array_merge($this->model);
                //$this->affichage();
            }
        }
    }

    public function affichage()
    {
        print_r($this->model);
    }
}
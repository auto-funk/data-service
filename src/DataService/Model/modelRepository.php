<?php

//namespace DataService\Model;
require 'modelInterface.php';
require 'modelClass.php';
require 'propertyClass.php';

class InMemoryModelRepository implements ModelInterface
{
    private $model;

    public function __construct(Model $model)
    {
       $this->model[]=$model;
    }

    public function find(Model $modele)
    {
        for($i=0;$i<count($this->model);$i++)
        {
            if(strcmp($this->model[$i]->getName(), $modele->getName()) == 0 )
            {
                return $this->model[$i];
            }
        }
        return null;
    }

    public function findBy(Property $property)
    {
        $models = array();
        for($i=0;$i<count($this->model);$i++)
        {
            for ($j=0; $j<count($this->model[$i]->getProperties()) ; $j++)
            {
                if($this->model[$i]->getProperty($j)->getName() == $property->getName())
                {
                    return $this->model[$i];
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
                //$this->display();
            }
        }
    }

    public function display()
    {
        var_dump($this->model);
    }
}
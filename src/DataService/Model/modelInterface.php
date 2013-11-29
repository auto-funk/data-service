<?php

//namespace DataService\Model;

interface ModelInterface
{
    public function findBy(Property $property);

    public function find(Model $model);

    public function findAll();

    public function add(Model $model);

    public function remove(Model $model);
}
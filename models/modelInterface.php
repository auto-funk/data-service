<?php

namespace models;

interface ModelInterface
{
    public function find(Property $property);

    public function findAll();

    public function add(Model $model);

    public function remove(Model $model);
}
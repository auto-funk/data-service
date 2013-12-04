<?php

namespace DataService\Model;

class InMemoryModelRepository implements ModelRepositoryInterface
{
    /**
     * @var Model[]
     */
    private $models;

    public function __construct(array $models)
    {
        $this->models = $models;
    }

    /**
     * {@inheritDoc}
     */
    public function find($name)
    {
        foreach ($this->models as $model) {
            if (strcmp($model->getName(), $name) === 0) {
                return $model;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->models;
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(Property $property)
    {
        $modelList = array();
        foreach ($this->models as $key => $value) {
            foreach ($this->models[$key]->getProperties() as $key2 => $value2) {
                if ($this->models[$key]->getProperty($key2)->getName() == $property->getName()) {
                    $modelList[] = $this->models[$key];
                }
            }
        }

        return $modelList;
    }

    /**
     * {@inheritDoc}
     */
    public function add(Model $model)
    {
        $this->models[] = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Model $model)
    {
        foreach ($this->models as $key => $value) {
            if ($value == $model) {
                unset($this->models[$key]);
                $this->models = array_merge($this->models);
            }
        }
    }
}

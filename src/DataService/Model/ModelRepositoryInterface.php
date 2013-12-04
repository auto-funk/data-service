<?php

namespace DataService\Model;

interface ModelRepositoryInterface
{
	/**
     * Return the model which contain the research property.
     *
     * @param Property $property
     *
     * @return Model
     */
    public function findBy(Property $property);

    /**
     * Return the research model.
     */
    public function find($name);

    /**
     * Return all models.
     *
     * @return Model[]
     */
    public function findAll();

    /**
     * Permit to add a model at the model list.
     *
     * @param Model $model
     */
    public function add(Model $model);

    /**
     * Permit to remove a model at the model list.
     */
    public function remove(Model $model);
}
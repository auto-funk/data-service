<?php

//namespace DataService\Model;

/** Model interface */
interface ModelInterface
{
	/** Return the model which contain the research property  */
    public function findBy(Property $property);

    /** Return the research model */
    public function find(Model $model);

    /** Return all models */
    public function findAll();

    /** Permit to add a model at the model list */
    public function add(Model $model);

    /** Permit to remove a model at the model list */
    public function remove(Model $model);

    /** Permit to display model list */
    public function display();
}
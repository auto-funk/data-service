<?php

namespace DataService\Model;

use DataService\Model\Model;
use DataService\Model\Metadata;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class YamlModelRepository implements ModelRepositoryInterface
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        (new Filesystem())->touch($this->filename);
    }

    /**
     * {@inheritDoc}
     */
    public function find($name){
        foreach ($this->findAll() as $model) {
            if ($model->isEqualTo($name)) {
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
        $models = array();
        foreach ($this->getRows() as $row) {
            $models[] = new Model(
                new Metadata($row['name'], $row['description']),
                $row['properties'],
                $row['filters']
            );
        }

        return $models;
    }

    /**
     * {@inheritDoc}
     */
    public function add(Model $model)
    {
        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($model->getMetadata()->isEqualTo(new Metadata($row['name'], $row['description']))) {
                continue;
            }
            //var_dump(new Metadata($row['metadata']));
            $rows[] = $row;
        }
        $testProp = $this->completeProperty($model->getProperties());
        echo "<br/> ********************************************************** <br/>";

        $rows[] = array(
            'name'          => $model->getName(),
            'description'   => $model->getDescription(),
            'properties'    => $testProp,
            'filters'       => $model->getFilters(),
        );

        file_put_contents($this->filename, Yaml::dump($rows));
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Model $model)
    {
        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($model->getMetadata()->isEqualTo(new Metadata($row['name'], $row['description']))) {
                continue;
            }
            $rows[] = $row;
        }
        file_put_contents($this->filename, Yaml::dump($rows));
    }

    private function getRows()
    {
        return Yaml::parse($this->filename) ?: array();
    }

    private function completeProperty(array $properties)
    {
        for($i = 0 ; $i < count($properties) ; $i++) {
            $newProperties[] = $properties[$i]->getArrayAttributes();
        }
        return $newProperties;
    }


    public function findBy(Property $property)
    {return null;}
}
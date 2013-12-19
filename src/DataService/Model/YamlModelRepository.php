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
    public function find($name)
    {
        foreach ($this->findAll() as $model) {
            if ($name === $this->returnName($model)) {
                return array($model);
            }
        }

        return null;
    }

    /**
     * Return model name
     *
     * @param Model[]
     * @return Model name
     */
    public function returnName(array $model)
    {
        foreach ($model as $key => $value) {
            if ($key === "metadata") {
                foreach ($value as $cle => $valeur) {
                    if ($cle === "name") {
                        return $valeur;
                    }
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $models = array();
        foreach ($this->getRows() as $row) {
                $models[] = array(
                    "properties" => $row['properties'],
                    "metadata" => array(
                        "name" => $row['name'], "description" => $row['description']),
                    "filters" => $row['filters']);
        }

        return $models;
    }

    /**
     * {@inheritDoc}/
     */
    public function add(Model $model)
    {
        $rows = array();
        foreach ($this->getRows() as $row) {
            if ($model->getMetadata()->isEqualTo(new Metadata($row['name'], $row['description']))) {
                continue;
            }
            $rows[] = $row;
        }

        $prop = $this->completeProperty($model->getProperties());
        $rows[] = array(
            'name'          => $model->getName(),
            'description'   => $model->getDescription(),
            'properties'    => $prop,
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

    /**
     * Allows to have a useful property array
     *
     * @param Old properties[]
     * @return New properties[]
     */
    private function completeProperty(array $properties)
    {
        for ($i = 0 ; $i < count($properties) ; $i++) {
            $newProperties[] = $properties[$i]->getArrayAttributes();
        }

        return $newProperties;
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(Property $property)
    {
        return null;
    }
}
